<?php

namespace Db;

use PDO;
use Utilities\Neon;
use Utilities\String;
use Utilities\Debug;
use Utilities\inputException;
use Utilities\dbException;

class Control
{

	/**
	 * Instance of Db
	 * @var object
	 */
	protected static $instance = false;

	/**
	 * Database configuration
	 * @var array
	 */
	private $db_c = array();

	/**
	 * Database object
	 * @var object
	 */
	private $con;

	/**
	 * Instantiates database config
	 * and establishes connection
	 */
	public function __construct()
	{
		$db_config = Neon::decode(file_get_contents(APP_DIR . "/_config/db.neon"));
		$this->db_c = $db_config["Connection"];

		$this->con = $this->connect();
	}

	/**
	 * Destroys database connection
	 * and unsets variables
	 */
	public function __destruct()
	{
		if ($this->con !== false) {
			$this->con = null;
		}

		$this->con = "";
		$this->db_c = "";
		$this->db_t = "";
	}

	/**
	 * Returns the instance of Db
	 * @return object
	 */
	public static function getInstance()
	{
		if (self::$instance === false) {
			self::$instance = new Control();
		}

		return self::$instance;
	}

	/**
	 * Connects to a database
	 * @return boolean | db object
	 */
	private function connect()
	{
		$pdo = new PDO($this->db_c["Dsn"], $this->db_c["User"], $this->db_c["Password"]);

		if (!$pdo) {
			Debug::err(new dbException('Connect error -> ' . implode(" , ", $pdo->errorInfo())));
			return false;
		}

		return $pdo;
	}

	/**
	 * Executes queries
	 * @param string $q
	 * @param array $p
	 * @param string $i
	 * @return mixed
	 */
	public function exec($q, $p = false, $i = "q")
	{
		if ($this->con !== false) {
			$s = $this->con->prepare($q);

			if ($p && is_array($p)) {
				foreach ($p as $k => $v)
				{
					if (!self::validParam($v)) {
						return false;
					}
					$s->bindParam($k, $v[0], $v[1], $v[2]);
				}
			}

			if (!$s->execute()) {
				Debug::err(new dbException('Query error ' . implode(" , ", $s->errorInfo())));
				return false;
			}

			switch ($i)
			{
				case "rowCount": return $s->rowCount();
				case "fetch": return $s->fetch(PDO::FETCH_ASSOC);
				case "fetchColumn": return $s->fetchColumn();
				case "fetchAll": return $s->fetchAll(PDO::FETCH_ASSOC);
				default: return $s;
			}
		}
		return false;
	}

	/**
	 * Gets last insert ID
	 * @return int
	 */
	public function getLastInsertID()
	{
		return $this->con->lastInsertId();
	}

	/**
	 * Checks if an entry exists
	 * @param string $t
	 * @param array $w
	 * @return boolean
	 */
	public function exists($t, array $w)
	{
		if (!$this->con) {
			return false;
		}

		if (!self::validWhere($w)) {
			return false;
		}

		if ($this->exec("SELECT " . $w[0] . " FROM $t WHERE " . $w[0] . " = :where", array(":where" => array($w[1], $w[2], $w[3])), "rowCount") > 0) {
			return true;
		}

		return false;
	}

	/**
	 * Inserts data into database
	 * @param string $t
	 * @param array $d
	 * @return boolean
	 */
	public function insert($t, array $d)
	{
		if ($this->con !== false) {
			foreach (array_values($d) as $v)
			{
				$p[current(array_keys($v))] = current(array_values($v));
				if (is_array($v) && count($v) > 0) {
					$st[] = current(array_keys($v));
				}
				else {
					Debug::err(new inputException(__METHOD__));
					return false;
				}
			}
			if ($this->exec("INSERT INTO $t (" . implode(" , ", array_keys($d)) . ") VALUES (" . implode(" , ", $st) . ")", $p)) {
				return true;
			}

			return false;
		}

		return false;
	}

	/**
	 * Updates data in database
	 * @param string $t
	 * @param array $d
	 * @param array $w
	 * @return boolean
	 */
	public function update($t, array $d, array $w)
	{
		if ($this->con !== false) {
			if (!self::validWhere($w)) {
				return false;
			}

			foreach ($d as $k => $v)
			{
				if (!isset($v[1]) or ! isset($v[2])) {
					Debug::err(new inputException(__METHOD__));
					return false;
				}
				if (!$this->exec(
												"UPDATE $t SET $k = :value WHERE " . $w[0] . " = :where", array(
										":value" => array($v[0], $v[1], $v[2]),
										":where" => array($w[1], $w[2], $w[3])
												)
								)) {
					return false;
				}
			}

			return true;
		}

		return false;
	}

	/**
	 * Removes data from database
	 * @param string $t
	 * @param array $w
	 * @return boolean
	 */
	public function delete($t, array $w)
	{
		if (!$this->con) {
			return false;
		}

		if (!self::validWhere($w)) {
			return false;
		}

		if ($this->exec("DELETE FROM $t WHERE " . $w[0] . " = :value", array(":value" => array($w[1], $w[2], $w[3])))) {
			return true;
		}

		return false;
	}

	/**
	 * Gets data from DB
	 * @param string | array $g
	 * @param string $t
	 * @param array $w
	 * @return boolean | array
	 */
	public function get($g, $t, array $w)
	{
		if (!$this->con) {
			return false;
		}

		if (!self::validWhere($w)) {
			return false;
		}

		if (is_array($g)) {
			$q = $this->exec("SELECT " . implode(" , ", $g) . " FROM $t WHERE " . $w[0] . " = :value", array(":value" => array($w[1], $w[2], $w[3])));
			$d = $q->fetch(PDO::FETCH_ASSOC);
		}
		else {
			$q = $this->exec("SELECT $g FROM $t WHERE " . $w[0] . " = :value", array(":value" => array($w[1], $w[2], $w[3])));
			$d = $q->fetch(PDO::FETCH_ASSOC);
		}

		return array("data" => $d, "rowCount" => $q->rowCount());
	}

	/**
	 * Validates WHERE statement arrays
	 * @param array $w
	 * @return boolean
	 */
	private static function validWhere(array $w)
	{
		if (!isset($w[1]) || !isset($w[2]) || !isset($w[3])) {
			Debug::err(new inputException(__METHOD__ . " input => " . String::format($w, "string")));
			return false;
		}

		return true;
	}

	/**
	 * Validates parameters
	 * @param array $p
	 * @return boolean
	 */
	private static function validParam(array $p)
	{
		if (!isset($p[0]) || !isset($p[1]) || !isset($p[2])) {
			Debug::err(new inputException(__METHOD__ . " input => " . String::format($p, "string")));
			return false;
		}

		return true;
	}

}
