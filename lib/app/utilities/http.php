<?php

namespace Utilities;

class Http
{

	/**
	 * Redirects to a specific url
	 * @param string $u
	 */
	public static function redirect($u)
	{
		if (!headers_sent()) {
			header("location: " . urldecode($u));
			exit;
		}
		if (!exit('<meta http-equiv="refresh" content="0; url=' . urldecode($u) . '"/>')) {
			Debug::err(new appException("Couldn't redirect to $u. Headers already sent."));
		}
	}

	/**
	 * Returns whether a POST request
	 * has been sent
	 * @param string $n
	 * @param string $t
	 * @return boolean
	 */
	public static function isRequest($n, $t = "post")
	{
		$p = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$g = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

		switch ($t)
		{
			case "post": return isset($p[$n]);
			case "get": return isset($g[$n]);
			default: return false;
		}
	}

	/**
	 * Returns sanitaised POST superglobal array
	 * @return array
	 */
	public static function getPost()
	{
		return filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	}

	/**
	 * Returns sanitaised GET superglobal array
	 * @return array
	 */
	public static function getGet()
	{
		return filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
	}

}
