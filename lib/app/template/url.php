<?php

namespace Template;

use Utilities\String;
use Utilities\inputException;
use Utilities\Debug;
use Utilities\appException;
use Utilities\Http;

class Url
{

	/**
	 * Returns base URL (for images, data)
	 * @return string
	 */
	public static function returnBaseUrl()
	{
		$s = filter_input_array(INPUT_SERVER, FILTER_SANITIZE_STRING);
		return "http" . (isset($s['HTTPS']) ? 's' : '') . "://{$s['HTTP_HOST']}";
	}

	/**
	 * Parses the current URL
	 * @global array $app
	 * @return array | boolean
	 */
	public static function parseUrl()
	{
		global $app;

		$s = filter_input_array(INPUT_SERVER, FILTER_SANITIZE_STRING);
		$u = explode("/", $s["REQUEST_URI"], 4);

		if (isset($u[3])) {
			if (empty($u[3]) || empty($u[2]) || empty($u[1])) {
				Debug::err(new appException("An invalid form of URL"));
				Http::redirect($app["ooopsPage"]);
			}

			return array(
					"template" => empty($u[1]) ? "welcome" : String::sanUrl($u[1]),
					"param" => String::sanUrl($u[2]),
					"extra" => String::sanUrl($u[3])
			);
		}
		elseif (isset($u[2])) {
			if (empty($u[2]) || empty($u[1])) {
				Debug::err(new appException("An invalid form of URL"));
				Http::redirect($app["ooopsPage"]);
			}

			return array(
					"template" => empty($u[1]) ? "welcome" : String::sanUrl($u[1]),
					"param" => String::sanUrl($u[2])
			);
		}
		elseif (isset($u[1])) {
			return array(
					"template" => empty($u[1]) ? "welcome" : String::sanUrl($u[1])
			);
		}
	}

	/**
	 * Generates a clean URL from parameters
	 * @param array $d
	 * @param boolean $b
	 * @return string | boolean
	 */
	public static function href(array $d, $b = false)
	{
		/**
		 * $d[0] = template
		 * $d[2] = param
		 * $d[2] = extra
		 */
		if (isset($d[0])) {
			if (isset($d[1]) && $d[1] !== "") {
				if (isset($d[2])) {
					$l = $b ? self::returnBaseUrl() : '';
					$l .= '/' . String::sanUrl(ltrim($d[0], "/")) . '/' . String::sanUrl($d[1]) . '/' . String::sanUrl($d[2]);
				}
				else {
					$l = $b ? self::returnBaseUrl() : '';
					$l .= '/' . String::sanUrl(ltrim($d[0], "/")) . '/' . String::sanUrl($d[1]);
				}
			}
			else {
				$l = $b ? self::returnBaseUrl() : '';
				$l .= '/' . String::sanUrl(ltrim($d[0], "/"));
			}

			return $l;
		}
		else {
			Debug::err(new inputException(__METHOD__));
			return false;
		}
	}

}
