<?php

namespace Utilities;

use Template\Url;

class Validate
{

	/**
	 * Validates e-mail format
	 * @param string $e
	 * @return boolean
	 */
	public static function email($e)
	{
		$d = explode("@", $e);

		if (!preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $e)) {
			return false;
		}

		if (preg_match("/localhost/i", Url::returnBaseUrl())) {
			return true;
		}

		if (!checkdnsrr($d[1], "MX")) {
			Debug::err(new appException("checkdnssrr() error for $e"));
			return false;
		}

		return true;
	}

	/**
	 * Validates name format
	 * @param string $n
	 * @return boolean
	 */
	public static function name($n)
	{
		if (!preg_match('/^([a-zA-Z.-]|[[:space:]]|ľ|š|č|ť|ž|ý|á|í|é|ú|ä|ň|ô|ö|ď|Ď|Ľ|Š|Č|Ť|Ž|Ý|Á|Í|É|Ú|Ä|Ň|Ô|Ö)+$/', $n)) {
			return false;
		}

		return true;
	}

	/**
	 * Validates password format
	 * @param string $p
	 * @return boolean
	 */
	public static function password($p)
	{
		if (!preg_match('/^.*(?=.{6,})(?=.*\d)(?=.*[a-žA-Ž]).*$/', $p) or preg_match("/abcdef|12345|54321|qwertzuiop|asdfghjkl|yxcvbnm|qwertyuiop|zxcvbnm|password/i", $p)) {
			return false;
		}

		return true;
	}

	/**
	 * Validates hash format
	 * @param string $p
	 * @return boolean
	 */
	public static function hash($p)
	{
		if (!preg_match('/([a-zA-Z0-9])/', $p)) {
			return false;
		}

		return true;
	}

}
