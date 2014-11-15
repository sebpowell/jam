<?php

namespace Utilities;

class Cookie
{

	private static $instance;
	private $cookie;

	/**
	 * Returns class object
	 * @return object
	 */
	public static function getInstance()
	{
		if (!is_object(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct()
	{
		$this->cookie = filter_input_array(INPUT_COOKIE, FILTER_SANITIZE_STRING);
	}

	/**
	 * Sets a cookie
	 * @param string $n
	 * @param string | int $v
	 * @param int $e_d
	 * @param string $s
	 * @return boolean
	 */
	public function set($n, $v, $e_d, $s = "/")
	{
		$e = time() + 3600 * 24 * $e_d;
		$this->cookie[$n] = $v;

		return setcookie($n, $v, $e, $s);
	}

	/**
	 * Unsets a cookie
	 * @param string $n
	 * @return boolean
	 */
	public function destroy($n)
	{
		$this->cookie[$n] = "";

		return setcookie($n, "", time() - 3600, "/");
	}

	/**
	 * Gets a specific cookie
	 * @param string $n
	 * @return string | int
	 */
	public function get($n)
	{
		return isset($this->cookie[$n]) ? $this->cookie[$n] : false;
	}

	/**
	 * Gets current cookie global variable
	 * @return array
	 */
	public function getAll()
	{
		return $this->cookie;
	}

}
