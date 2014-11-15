<?php

namespace Template;

use Utilities\Http;
use Utilities\Debug;
use Utilities\String;
use Utilities\Session;
use Utilities\appException;

class Control extends Url
{

	/**
	 * Current Url
	 * @var array
	 */
	private $url;

	/**
	 * Current template
	 * @var string
	 */
	protected $template;

	/**
	 * Current param
	 * @var string
	 */
	protected $param;

	/**
	 * Current extra
	 * @var string
	 */
	protected $extra;

	/**
	 * Current language
	 * @var string
	 */
	protected $lang;

	/**
	 * Current controller object
	 * @var object
	 */
	protected $controller;

	/**
	 * Strings to look for
	 * @var array
	 */
	private $search = array(
			"{{", "}}",
			"{?=", "=?}",
			"{?", "?}",
			"{module", "/module}",
			"{inc", "/inc}",
			"{href", "/href}"
	);

	/**
	 * Strings to replace
	 * @var array
	 */
	private $replace = array(
			"<?php echo(", "); ?>",
			"<?php echo(", "); ?>",
			"<?php ", " ?>",
			'<?php Template\Template::getModule("', '"); ?>',
			'<?php Template\Template::getLayout("', '"); ?>',
			'<?php echo Template\Url::href(', '); ?>'
	);

	/**
	 * Assigns template, url param, and extra url param
	 */
	public function __construct()
	{
		$this->url = $this->parseUrl();

		$this->assignLang();
		$this->assignControllerVars();
		$this->parseLayouts();
	}

	/**
	 * Assigns template to a variable (must be set)
	 */
	private function assignTemplate()
	{
		$this->template = $this->url["template"];
	}

	/**
	 * Assigns parameter to
	 * a variable if it is set
	 */
	private function assignParam()
	{
		$this->param = isset($this->url["param"]) ? $this->url["param"] : "";
	}

	/**
	 * Assigns extra parameter to
	 * a variable if it is set
	 */
	private function assignExtra()
	{
		$this->extra = isset($this->url["extra"]) ? $this->url["extra"] : "";
	}

	/**
	 * Assigns variables from controller
	 * and passes them through $this->template->variable
	 * @global array $app
	 * @return boolean
	 */
	private function assignControllerVars()
	{
		global $app;

		$this->assignTemplate();
		$this->assignParam();
		$this->assignExtra();

		$p = WWW_APP_DIR . "/template/" . $this->template . "/_controller.php";

		if (!is_file($p) || !file_exists($p)) {
			Debug::err(new appException("Controller $p not found!"));
			Http::redirect($app["ooopsPage"]);

			return false;
		}

		include_once $p;

		$this->controller = new \controller;
		$vTemp = get_object_vars($this->controller);

		$this->vars = (array) $vTemp["template"];
	}

	/**
	 * Assigns current language from $_SESSION
	 * if it exists. Otherwise, it assigns
	 * the default app language
	 * @global array $app
	 */
	private function assignLang()
	{
		global $app;

		$s = Session::getInstance();
		$session = $s->get();

		$lang = isset($session["appLang"]) && in_array($session["appLang"], $app["langs"]) ? $session["appLang"] : $app["lang"];

		$app["lang"] = $lang;
	}

	/**
	 * Gets content of a layout, if it exists
	 * @param string $t
	 * @param boolean | string $i
	 * @return array | boolean
	 */
	private function getContent($t, $i = false)
	{
		switch ($t)
		{
			case "common":
				$lt = "/template/_common/layout.lt";
				$n = "common";
				break;
			case "template":
				$lt = "/template/" . $this->template . "/layout.lt";
				$n = "template" . $this->template;
				break;
			case "param":
				$lt = "/template/" . $this->template . "/_param_" . $this->param . ".lt";
				$n = "param" . $this->param;
				break;
			case "extra":
				$lt = "/template/" . $this->template . "/_extra_" . $this->extra . ".lt";
				$n = "extra" . $this->extra;
				break;
			case "module":
				$lt = "/module/" . (string) $i . "/layout.lt";
				$n = "module" . $i;
				break;
		}



		$ltF = WWW_APP_DIR . $lt;
		$tmpF = APP_DIR . "/temp/_templates/" . md5($n) . ".php";

		if (file_exists($ltF) && is_file($ltF)) {
			clearstatcache();

			$ltLastMod = filemtime($ltF);
			$tpLastMod = file_exists($tmpF) ? filemtime($tmpF) : false;

			if (!$tpLastMod) {
				return array(
						"fileContents" => file_get_contents($ltF),
						"templateFile" => $tmpF
				);
			}

			if ($tpLastMod && $ltLastMod < $tpLastMod) {
				$this->doNotWrite[] = $tmpF;
			}

			return array(
					"fileContents" => file_get_contents($ltF),
					"templateFile" => $tmpF
			);
		}

		return false;
	}

	/**
	 * Parses all available layouts
	 */
	private function parseLayouts()
	{
		$lt = array(
				"common" => $this->getContent("common"),
				"template" => $this->getContent("template"),
				"param" => $this->getContent("param"),
				"extra" => $this->getContent("extra"),
		);

		foreach ($lt as $k => $v)
		{
			if ($v !== false) {
				preg_match_all('/\{module(.*?)\/module}/', $v["fileContents"], $rMod);

				if (count($rMod[1]) > 0) {
					foreach ($rMod[1] as $mod)
					{
						$cMod = $this->getContent("module", trim($mod));

						if ($cMod) {
							$this->parseLt($cMod["fileContents"], $cMod["templateFile"]);
						}
					}
				}

				$this->parseLt($v["fileContents"], $v["templateFile"]);
			}
		}
	}

	/**
	 * Parses individual layout
	 * @param string $lt
	 * @param string $tp
	 */
	private function parseLt($lt, $tp)
	{
		if (preg_match_all('/\{{(.*?)\}}/', $lt, $rCode)) {
			$code = $rCode[1];

			foreach ($code as $k)
			{
				$var = trim($k);

				$findHelpers = explode("|", $var);
				$varExploded = explode(".", $findHelpers[0]);

				$helpers = isset($findHelpers[1]) ? array_slice($findHelpers, 1) : false;

				$numberOfElements = count($varExploded);
				$s = '["' . $varExploded[0] . '"]';

				if ($numberOfElements > 1) {
					foreach (array_slice($varExploded, 1) as $v)
					{
						$s .= '["' . $v . '"]';
					}
				}

				$lt = str_replace($var, '$template' . $s, $lt);
				if (is_array($helpers)) {
					eval('@$rVar = $this->vars' . $s . ';');

					$this->addHelpers($helpers, $rVar, $s);
				}
			}
		}

		$out = str_replace($this->search, $this->replace, $lt);

		$this->writeTemplate($out, $tp);
	}

	/**
	 * Adds helpers, edits input and updates $template
	 * @param array $hs
	 * @param string $s
	 * @param string $t
	 */
	private function addHelpers(array $hs, $s, $t)
	{
		$s = preg_replace('/\<\?/i', '', $s);

		foreach ($hs as $h)
		{
			$l = false;

			if (preg_match("/:/", $h)) {
				$l = explode(":", $h);
			}

			if ($l && isset($l[1])) {
				$h = $l[0];
				$l = $l[1];
			}

			switch ($h)
			{
				case "escape":
					$s = String::san($s);
					break;
				case "upper":
					$s = mb_strtoupper($s);
					break;
				case "lower":
					$s = mb_strtolower($s);
					break;
				case "capitalise":
					$s = ucwords($s);
					break;
				case "dump":
					$s = "<pre>" . json_encode($s) . "</pre>";
					break;
				case "size":
					$s = String::formatSize((int) $s);
					break;
				case "trim":
					$s = trim($s);
					break;
				case "truncate":
					$s = mb_substr($s, 0, $l);
					break;
				case "whitespace":
					$s = String::sanWhitespace($s, $l);
					break;
				case "linkify":
					$s = String::genLink($s);
					break;
				case "mailify":
					$s = String::genMailto($s);
					break;
				case "url":
					$s = String::sanUrl($s);
					break;
			}
		}

		eval('$this->vars' . $t . ' = $s;');
	}

	/**
	 * Creates a new template file
	 * @param string $c
	 * @param string $tp
	 */
	private function writeTemplate($c, $tp)
	{
		$tDir = APP_DIR . "/temp/_templates";

		if (!is_dir($tDir)) {
			mkdir($tDir);
		}

		$exc = isset($this->doNotWrite) ? $this->doNotWrite : array();

		if (!in_array($tp, $exc)) {
			file_put_contents($tp, $c);
		}
	}

}
