<?php

namespace Controller;

use Db\Control as Db;
use Utilities\Debug;
use Utilities\appException;
use Utilities\Http;
use Template\Url;

class templateController
{

	public function __construct()
	{
		global $app;

		$this->app = $app;
		$this->page = array(
				"url" => Url::parseUrl(),
				"title" => "Page",
		);

		if (DEBUG && GRID) {
			$this->page["scripts"][] = "grid";
		}
	}

	/**
	 * Checks URL parameter
	 * @param array $dbe
	 * @return boolean
	 */
	public function parseParam($dbe = false)
	{
		$f = WWW_APP_DIR . "/template/" . $this->page["url"]["template"] . "/_param_" . $this->page["url"]["param"] . ".lt";

		if (is_file($f) && file_exists($f)) {
			return true;
		}
		elseif ($dbe && is_array($dbe)) {


			if (!in_array($this->page["url"]["param"], $dbe)) {
				goto err;
			}

			return true;
		}

		err:
		{
			Debug::err(new appException("Parameter " . $this->page["url"]["param"] . " not recognised."));
			Http::redirect(Url::href(array($this->app["ooopsPage"])));
			return false;
		}
	}

	/**
	 * Checks URL extra parameter
	 * @param array $a
	 * @param array $dbe
	 * @return boolean
	 */
	public function parseExtra($a = false, $dbe = false)
	{
		$f = WWW_APP_DIR . "/template/" . $this->page["url"]["template"] . "/_extra_" . $this->page["url"]["extra"] . ".lt";

		if (is_file($f) && file_exists($f)) {
			return true;
		}
		elseif ($a && is_array($a)) {
			if (!in_array($this->page["url"]["extra"], $a)) {
				goto err;
			}

			return true;
		}
		elseif ($dbe && is_array($dbe)) {
			$db = Db::getInstance();

			if (!$db->exists($dbe[0], array($dbe[1], $this->page["url"]["extra"], $dbe[2], $dbe[3]))) {
				goto err;
			}

			return true;
		}

		err:
		{
			Debug::err(new appException("Extra parameter " . $this->page["url"]["extra"] . " not recognised."));
			Http::redirect(Url::href(array($this->app["ooopsPage"])));
			return false;
		}
	}

}
