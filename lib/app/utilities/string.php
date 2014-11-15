<?php

namespace Utilities;

use Normalizer;

class String
{

	private static $ch = array('Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r');

	/**
	 * Returns SEO friendly URLs
	 * @param string $u
	 * @return string
	 */
	public static function sanUrl($u)
	{
		if (class_exists("Normalizer", false)) {
			$c = preg_replace('/\p{M}/u', '', Normalizer::normalize($u, Normalizer::FORM_D));
		}
		else {
			$c = strtr($u, static::$ch);
		}

		$c = preg_replace("/\%/", "-percentage-", $c);
		$c = preg_replace("/\@/", "-at-", $c);
		$c = preg_replace("/\&/", "-and-", $c);
		$c = preg_replace("/[\/_|+ -]+/", "-", $c);
		$c = preg_replace("/[\!?<>]+/", "", $c);
		$c = mb_strtolower(trim($c, "-"));

		return $c;
	}

	/**
	 * Returns sanitised string
	 * @param string $s
	 * @return string
	 */
	public static function san($s)
	{
		return filter_var($s, FILTER_SANITIZE_STRING);
	}

	/**
	 * Strips all whitespace in a string
	 * @param string $s
	 * @param string $r
	 * @return string
	 */
	public static function sanWhitespace($s, $r = "-")
	{
		return preg_replace('/\s+/', $r, $s);
	}

	/**
	 * Returns the length of a string
	 * @global array $app
	 * @param string $s
	 * @return boolean | int
	 */
	public static function len($s)
	{
		global $app;

		if (is_string($s)) {
			return mb_strlen($s);
		}

		Debug::err(new inputException(__METHOD__));
		return false;
	}

	/**
	 * Transforms text into a readable form
	 * by making links clickable
	 * @param string $s
	 * @return string
	 */
	public static function genLink($s)
	{
		return preg_replace('/(?<!S)((http(s?):\/\/)|(www.))+([\w.1-9\&=#?\-+~%;\/]+)/', '<a target="_blank" href="http$3://$4$5">http$3://$4$5</a>', $s);
	}

	/**
	 * Transforms text into a readable form
	 * by making mails clickable
	 * @param string $s
	 * @return string
	 */
	public static function genMailto($s)
	{
		return preg_replace('/(\S+@\S+\.\S+)/', '<a href="mailto:$1">$1</a>', $s);
	}

	/**
	 * Formats time() into date
	 * @param string $f
	 * @param int $t
	 * @return string | boolean
	 */
	public static function formatTime($f = "d M Y", $t = false)
	{
		if ($t) {
			return date($f, $t);
		}

		return date($f, time());
	}

	/**
	 * Formats bytes into readable form
	 * @param int $b
	 * @return string
	 */
	public static function formatSize($b)
	{
		$bt = (int) $b;

		if ($bt <= 0) {
			return "0 bytes";
		}

		$s = array('bytes', 'kb', 'MB', 'GB', 'TB', 'PB');
		$e = floor(log($bt) / log(1024));

		return sprintf('%.2f ' . $s[$e], ($bt / pow(1024, $e)));
	}

	/**
	 * Generates random strings
	 * @param int $l
	 * @return string | boolean
	 */
	public static function generate($l = 64)
	{
		$a = 'abcdefghijklmnopqrstuvwxyz1234567890';
		$s = '';

		if (!is_int($l) or $l > 128) {
			Debug::err(new appException(__METHOD__));
			return false;
		}

		for ($i = 1; $i < $l + 1; $i++)
		{
			$r = $a[mt_rand(0, 35)];
			$s .= $r;
		}

		return $s;
	}

	/**
	 * Encrypts data using AES-128-CBC method
	 * @param string $d
	 * @return string
	 */
	public static function encrypt128($d)
	{
		$dEnc = openssl_encrypt($d, "aes-128-cbc", AES_128_PASS, true, AES_128_IV);
		$dHex = bin2hex($dEnc);

		return $dHex;
	}

	/**
	 * Decrypts data using AES-128-CBC method
	 * @param string $d
	 * @return string
	 */
	public static function decrypt128($d)
	{
		$dBin = hex2bin($d);
		$dDec = openssl_decrypt($dBin, "aes-128-cbc", AES_128_PASS, true, AES_128_IV);

		return $dDec;
	}

}
