<?php

namespace Template;

class Template extends Control
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Initialises layout rendering
	 * @global array $template
	 */
	public function run()
	{
		// This makes $template globally accessible
		global $template;

		$template = $this->vars;

		include_once APP_DIR . "/temp/_templates/" . md5("common") . ".php";
	}

	/**
	 * Renders modules
	 * @global array $template
	 * @param string $n
	 */
	public static function getModule($n)
	{
		// This makes $template globally accessible
		global $template;

		$n = "module" . trim($n);
		include_once APP_DIR . "/temp/_templates/" . md5($n) . ".php";
	}

	/**
	 * Renders layouts
	 * @global array $template
	 * @param string $n
	 */
	public static function getLayout($n)
	{
		// This makes $template globally accessible
		global $template;

		$url = Url::parseUrl();

		switch (trim($n))
		{
			case "template":
				$n = "template" . $url["template"];
				break;
			case "param":
				$n = isset($url["param"]) ? "param" . $url["param"] : false;
				break;
			case "extra":
				$n = isset($url["extra"]) ? "extra" . $url["extra"] : false;
				break;
		}

		$f = APP_DIR . "/temp/_templates/" . md5($n) . ".php";

		if ($n !== false && file_exists($f)) {
			include_once $f;
		}
	}

}
