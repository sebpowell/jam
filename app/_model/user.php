<?php

namespace Model;

use Db\Control as Db;
use Utilities\Http;
use Utilities\Alert;
use Utilities\Debug;
use Utilities\Session;
use Utilities\inputException;
use Utilities\Image;
use Utilities\String;

class User
{

	/**
	 * Errors and alerts
	 * @var array
	 */
	private static $errors = array(
			"register" => array(
					"wrongInput" => "Oh no! The data you entered must have been invalid.",
					"userExists" => "Oh no! It seems this user already exists, please try again.",
					"unknownErr" => "Oh no! An unknown error occured, please try again.",
					"success" => "Congratulations! You have successfully signed up."
			),
			"login" => array(
					"wrongCombination" => "Oh no! It seems your password is incorrect :-(",
					"success" => "Congratulations! Your login was successfull.",
			),
			"update" => array(
					"unknownErr" => "Oh no! An unknown error occured, please try again.",
					"success" => "Congratulations! Your profile was successfully updated."
			)
	);

	/**
	 * Current user ID, instantiated
	 * via the construct function
	 * @var int
	 */
	public $id;

	/**
	 * Database connection
	 * @var object
	 */
	private $db;

	/**
	 * Current session container
	 * @var object
	 */
	private $session;

	public function __construct()
	{
		global $app;

		$this->session = Session::getInstance();
		$this->db = Db::getInstance();

		$s = $this->session->get();
		$this->id = $this->exists((isset($s["userID"])) ? (int) $s["userID"] : false);

		if (!is_int($this->id)) {
			Http::redirect($app["welcomePage"]);
		}
	}

	/**
	 * Redirects to user page if user is signed in
	 * @global array $app
	 */
	public static function redirectIfSignedIn()
	{
		global $app;

		if (self::isSignedIn()) {
			Http::redirect($app["userPage"]);
		}
	}

	/**
	 * Returns whether user is signed in
	 * @return boolean
	 */
	public static function isSignedIn()
	{
		$session = Session::getInstance();
		$s = $session->get();

		if (isset($s["userID"]) && is_int($s["userID"])) {
			return true;
		}

		return false;
	}

	/**
	 * Checks if a user exists provided
	 * a certain ID value
	 * @param int $id
	 * @return int | boolean
	 */
	public function exists($id)
	{
		if (is_int($id)) {
			$d = $this->db->exists("user", array("ID", $id, 1, 11));

			if ($d === true) {
				return $id;
			}
		}

		return false;
	}

	/**
	 * Encrypts password
	 * @param string $p
	 * @param boolean | string $s
	 * @return boolean
	 */
	public static function encryptPassword($p, $s = false)
	{
		if (empty($p)) {
			Debug::err(new inputException(__METHOD__));
			return false;
		}

		if (!$s) {
			$s = bin2hex(openssl_random_pseudo_bytes(22));
		}

		$h = crypt(urlencode($p), '$2y$11$' . $s);

		return array("salt" => $s, "password" => $h);
	}

	/**
	 * Signs user up
	 * @param array $d
	 * @return string
	 * @throws inputException
	 */
	public static function register(array $d)
	{
		$db = Db::getInstance();

		$ins = $db->insert($d["table"], $d["data"]);

		/**
		 * Create multi-identification encrypted ID
		 * helps in large-scale projects
		 */
		$lID = (int) $db->getLastInsertID();
		$uID = self::uIDencrypt($d["table"], $lID);
		$up = $db->update($d["table"], array("uID" => array($uID, 2, 64)), array("ID", $lID, 1, 11));

		if ($ins !== true || $up !== true) {
			return Alert::render(static::$errors[__FUNCTION__]["unknownErr"], "alert error");
		}

		return Alert::render(static::$errors[__FUNCTION__]["success"], "alert success");
	}

	/**
	 * Signs user in
	 * @global array $app
	 * @param string $e
	 * @param string $p
	 * @return string
	 */
	public static function login($e, $p)
	{
		global $app;

		$db = Db::getInstance();
		$session = Session::getInstance();

		$d = $db->exec("SELECT language.Title as languageTitle, user.Email, user.Name, user.Salt, user.Password, user.Language, user.ID FROM user INNER JOIN language ON user.Language = language.ID WHERE user.Email = :email", array(":email" => array($e, 2, 128)), "fetch");

		$pw = self::encryptPassword($p, $d["Salt"]);

		if ($d["Password"] === $pw["password"]) {
			$session->set("userID", (int) $d["ID"]);
			$session->set("appLang", $d["languageTitle"]);

			Http::redirect($app["userPage"]);
			return Alert::render(static::$errors[__FUNCTION__]["success"], "alert success");
		}

		return Alert::render(static::$errors[__FUNCTION__]["wrongCombination"], "alert error");
	}

	/**
	 * Updates user information
	 * @param array $d
	 * @param int $id
	 * @param boolean | array $i
	 * @return string
	 */
	public static function update(array $d, $id, $i = false)
	{
		$db = Db::getInstance();
		$session = Session::getInstance();
		$img = false;

		if ($db->update("user", $d, array("ID", $id, 1, 11))) {
			if ($i) {
				$img = Image::createThumbs($i["tmp_name"], $id);

				if ($img === false || !$db->update("user", array("ProfilePicture" => array($img, 2, 128)), array("ID", $id, 1, 11))) {
					return Alert::render(static::$errors[__FUNCTION__]["unknownErr"], "alert error");
				}
			}

			$l = $db->get("Title", "language", array("ID", $d["Language"][0], 1, 11));

			$session->set("appLang", $l["data"]["Title"]);
			return Alert::render(static::$errors[__FUNCTION__]["success"], "alert success");
		}

		return Alert::render(static::$errors[__FUNCTION__]["unknownErr"], "alert error");
	}

	/**
	 * Returns user data
	 * @param array | string $d
	 * @return array
	 */
	public function getData($d)
	{
		return $this->db->get($d, "user", array("ID", $this->id, 1, 11));
	}

	/**
	 * Signs user out
	 * @return boolean
	 */
	public function logout()
	{
		global $app;

		$this->session->destroy("userID");

		Http::redirect($app["welcomePage"]);
	}

	/**
	 * Encrypts user id based on
	 * several information
	 * @param string $tableName
	 * @param int $lastID
	 * @return string
	 */
	public static function uIDencrypt($tableName, $lastID)
	{
		$cpt1 = strlen($tableName) > 5 ? substr($tableName, 0, 5) : str_pad($tableName, 5, "-", STR_PAD_RIGHT);
		$cpt2 = str_pad($lastID, 10, 0, STR_PAD_LEFT);
		$cpt3 = time();

		$rawID = $cpt1 . $cpt2 . $cpt3;

		return String::encrypt128($rawID);
	}

	/**
	 * Decrypts user id and returns information
	 * @param string $d
	 * @return array
	 */
	public static function uIDdecrypt($d)
	{
		$rawID = String::decrypt128($d);

		$dbName = substr($rawID, 0, 5);
		$id = substr($rawID, 5, 10);
		$time = substr($rawID, 15, 10);

		$dDec = array(
				"dbName" => rtrim($dbName, "-"),
				"id" => (int) ltrim($id, 0),
				"time" => (int) $time
		);

		return $dDec;
	}

}
