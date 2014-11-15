<?php

namespace Utilities;

class Session
{

	private static $instance;

	/**
	 * Defines the idle time after
	 * which session is destroyed
	 * @var int
	 */
	private static $destroyTimeout = 3600;

	/**
	 * Current session container
	 * @var array
	 */
	private $session;

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
		session_start();

		$this->session = $_SESSION;

		$this->check();
	}

	/**
	 * Returns current session
	 * @return mixed
	 */
	public function get()
	{
		return isset($this->session["app"]) ? $this->session["app"] : false;
	}

	/**
	 * Checks session validity
	 * @return boolean
	 */
	private function check()
	{
		session_regenerate_id();

		$key = isset($this->get()["key"]) ? $this->get()["key"] : false;
		$lastAction = isset($this->get()["lastAction"]) ? (int) $this->get()["lastAction"] : false;

		if (is_int($lastAction)) {
			if ((time() - $lastAction) > static::$destroyTimeout) {
				$this->destroy();
				return false;
			}
		}

		$this->set("lastAction", time());

		$serv = filter_input_array(INPUT_SERVER, FILTER_SANITIZE_STRING);
		$array = array(
				"userAgent" => $serv["HTTP_USER_AGENT"],
				"remoteAddr" => $serv["REMOTE_ADDR"],
		);

		$keyN = sha1(serialize($array));

		if (!$key) {
			$this->set("key", $keyN);
			return true;
		}

		if ($key === $keyN) {
			return true;
		}

		session_regenerate_id(true);

		$this->destroy();
		$this->set("lastAction", time());
		$this->set("key", $keyN);
	}

	/**
	 * Sets a session key
	 * @param string $k
	 * @param mixed $v
	 * @return boolean
	 */
	public function set($k, $v)
	{
		$this->session["app"][$k] = $v;
		$_SESSION["app"][$k] = $v;
	}

	/**
	 * Destroys a session key or a whole session
	 * @param string $k
	 * @return boolean
	 */
	public function destroy($k = true)
	{
		if (is_bool($k) && $k) {
			$this->session["app"] = "";
			$_SESSION["app"] = "";

			return true;
		}

		if (isset($this->session["app"][$k])) {
			$this->session["app"][$k] = "";
			unset($_SESSION["app"][$k]);
		}

		return true;
	}

}
