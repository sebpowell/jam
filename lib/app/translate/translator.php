<?php

use Utilities\Neon;
use Utilities\Debug;
use Utilities\appException;

class Translate
{

	/**
	 * Returns localised string
	 * @global array $app
	 * @param string | int $e
	 * @param string $l
	 * @return string
	 */
	public static function getEx($e, $l = false)
	{
		global $app;

		if ($l) {
			$lang = $l;
		}
		else {
			$lang = $app["lang"];
		}

		$d = Neon::decode(file_get_contents(APP_DIR . "/_config/localisation.neon"));
		$r = $d[$e][$lang];

		if (!isset($r)) {
			Debug::err(new appException("Key $e not found!"));
			return $e;
		}

		return $r;
	}

}
