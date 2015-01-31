<?php

namespace Utilities;

use Normalizer;

class String
{

	private static $ch = array('Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r');

	/**
	 * Returns SEO friendly URLs
	 * @param string $str
	 * @param array $options
	 * @return string
	 */
	public static function sanUrl($str, $options = array()) {
	// Make sure string is in UTF-8 and strip invalid UTF-8 characters
	$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

	$defaults = array(
		'delimiter' => '-',
		'limit' => null,
		'lowercase' => true,
		'replacements' => array(),
		'transliterate' => false,
	);

	// Merge options
	$options = array_merge($defaults, $options);

	$char_map = array(
		// Latin
		'Ã€' => 'A', 'Ã' => 'A', 'Ã‚' => 'A', 'Ãƒ' => 'A', 'Ã„' => 'A', 'Ã…' => 'A', 'Ã†' => 'AE', 'Ã‡' => 'C',
		'Ãˆ' => 'E', 'Ã‰' => 'E', 'ÃŠ' => 'E', 'Ã‹' => 'E', 'ÃŒ' => 'I', 'Ã' => 'I', 'ÃŽ' => 'I', 'Ã' => 'I',
		'Ã' => 'D', 'Ã‘' => 'N', 'Ã’' => 'O', 'Ã“' => 'O', 'Ã”' => 'O', 'Ã•' => 'O', 'Ã–' => 'O', 'Å' => 'O',
		'Ã˜' => 'O', 'Ã™' => 'U', 'Ãš' => 'U', 'Ã›' => 'U', 'Ãœ' => 'U', 'Å°' => 'U', 'Ã' => 'Y', 'Ãž' => 'TH',
		'ÃŸ' => 'ss',
		'Ã ' => 'a', 'Ã¡' => 'a', 'Ã¢' => 'a', 'Ã£' => 'a', 'Ã¤' => 'a', 'Ã¥' => 'a', 'Ã¦' => 'ae', 'Ã§' => 'c',
		'Ã¨' => 'e', 'Ã©' => 'e', 'Ãª' => 'e', 'Ã«' => 'e', 'Ã¬' => 'i', 'Ã­' => 'i', 'Ã®' => 'i', 'Ã¯' => 'i',
		'Ã°' => 'd', 'Ã±' => 'n', 'Ã²' => 'o', 'Ã³' => 'o', 'Ã´' => 'o', 'Ãµ' => 'o', 'Ã¶' => 'o', 'Å‘' => 'o',
		'Ã¸' => 'o', 'Ã¹' => 'u', 'Ãº' => 'u', 'Ã»' => 'u', 'Ã¼' => 'u', 'Å±' => 'u', 'Ã½' => 'y', 'Ã¾' => 'th',
		'Ã¿' => 'y',

		// Latin symbols
		'Â©' => '(c)',

		// Greek
		'Î‘' => 'A', 'Î’' => 'B', 'Î“' => 'G', 'Î”' => 'D', 'Î•' => 'E', 'Î–' => 'Z', 'Î—' => 'H', 'Î˜' => '8',
		'Î™' => 'I', 'Îš' => 'K', 'Î›' => 'L', 'Îœ' => 'M', 'Î' => 'N', 'Îž' => '3', 'ÎŸ' => 'O', 'Î ' => 'P',
		'Î¡' => 'R', 'Î£' => 'S', 'Î¤' => 'T', 'Î¥' => 'Y', 'Î¦' => 'F', 'Î§' => 'X', 'Î¨' => 'PS', 'Î©' => 'W',
		'Î†' => 'A', 'Îˆ' => 'E', 'ÎŠ' => 'I', 'ÎŒ' => 'O', 'ÎŽ' => 'Y', 'Î‰' => 'H', 'Î' => 'W', 'Îª' => 'I',
		'Î«' => 'Y',
		'Î±' => 'a', 'Î²' => 'b', 'Î³' => 'g', 'Î´' => 'd', 'Îµ' => 'e', 'Î¶' => 'z', 'Î·' => 'h', 'Î¸' => '8',
		'Î¹' => 'i', 'Îº' => 'k', 'Î»' => 'l', 'Î¼' => 'm', 'Î½' => 'n', 'Î¾' => '3', 'Î¿' => 'o', 'Ï€' => 'p',
		'Ï' => 'r', 'Ïƒ' => 's', 'Ï„' => 't', 'Ï…' => 'y', 'Ï†' => 'f', 'Ï‡' => 'x', 'Ïˆ' => 'ps', 'Ï‰' => 'w',
		'Î¬' => 'a', 'Î­' => 'e', 'Î¯' => 'i', 'ÏŒ' => 'o', 'Ï' => 'y', 'Î®' => 'h', 'ÏŽ' => 'w', 'Ï‚' => 's',
		'ÏŠ' => 'i', 'Î°' => 'y', 'Ï‹' => 'y', 'Î' => 'i',

		// Turkish
		'Åž' => 'S', 'Ä°' => 'I', 'Ã‡' => 'C', 'Ãœ' => 'U', 'Ã–' => 'O', 'Äž' => 'G',
		'ÅŸ' => 's', 'Ä±' => 'i', 'Ã§' => 'c', 'Ã¼' => 'u', 'Ã¶' => 'o', 'ÄŸ' => 'g',

		// Russian
		'Ð' => 'A', 'Ð‘' => 'B', 'Ð’' => 'V', 'Ð“' => 'G', 'Ð”' => 'D', 'Ð•' => 'E', 'Ð' => 'Yo', 'Ð–' => 'Zh',
		'Ð—' => 'Z', 'Ð˜' => 'I', 'Ð™' => 'J', 'Ðš' => 'K', 'Ð›' => 'L', 'Ðœ' => 'M', 'Ð' => 'N', 'Ðž' => 'O',
		'ÐŸ' => 'P', 'Ð ' => 'R', 'Ð¡' => 'S', 'Ð¢' => 'T', 'Ð£' => 'U', 'Ð¤' => 'F', 'Ð¥' => 'H', 'Ð¦' => 'C',
		'Ð§' => 'Ch', 'Ð¨' => 'Sh', 'Ð©' => 'Sh', 'Ðª' => '', 'Ð«' => 'Y', 'Ð¬' => '', 'Ð­' => 'E', 'Ð®' => 'Yu',
		'Ð¯' => 'Ya',
		'Ð°' => 'a', 'Ð±' => 'b', 'Ð²' => 'v', 'Ð³' => 'g', 'Ð´' => 'd', 'Ðµ' => 'e', 'Ñ‘' => 'yo', 'Ð¶' => 'zh',
		'Ð·' => 'z', 'Ð¸' => 'i', 'Ð¹' => 'j', 'Ðº' => 'k', 'Ð»' => 'l', 'Ð¼' => 'm', 'Ð½' => 'n', 'Ð¾' => 'o',
		'Ð¿' => 'p', 'Ñ€' => 'r', 'Ñ' => 's', 'Ñ‚' => 't', 'Ñƒ' => 'u', 'Ñ„' => 'f', 'Ñ…' => 'h', 'Ñ†' => 'c',
		'Ñ‡' => 'ch', 'Ñˆ' => 'sh', 'Ñ‰' => 'sh', 'ÑŠ' => '', 'Ñ‹' => 'y', 'ÑŒ' => '', 'Ñ' => 'e', 'ÑŽ' => 'yu',
		'Ñ' => 'ya',

		// Ukrainian
		'Ð„' => 'Ye', 'Ð†' => 'I', 'Ð‡' => 'Yi', 'Ò' => 'G',
		'Ñ”' => 'ye', 'Ñ–' => 'i', 'Ñ—' => 'yi', 'Ò‘' => 'g',

		// Czech
		'ÄŒ' => 'C', 'ÄŽ' => 'D', 'Äš' => 'E', 'Å‡' => 'N', 'Å˜' => 'R', 'Å ' => 'S', 'Å¤' => 'T', 'Å®' => 'U',
		'Å½' => 'Z',
		'Ä' => 'c', 'Ä' => 'd', 'Ä›' => 'e', 'Åˆ' => 'n', 'Å™' => 'r', 'Å¡' => 's', 'Å¥' => 't', 'Å¯' => 'u',
		'Å¾' => 'z',

		// Polish
		'Ä„' => 'A', 'Ä†' => 'C', 'Ä˜' => 'e', 'Å' => 'L', 'Åƒ' => 'N', 'Ã“' => 'o', 'Åš' => 'S', 'Å¹' => 'Z',
		'Å»' => 'Z',
		'Ä…' => 'a', 'Ä‡' => 'c', 'Ä™' => 'e', 'Å‚' => 'l', 'Å„' => 'n', 'Ã³' => 'o', 'Å›' => 's', 'Åº' => 'z',
		'Å¼' => 'z',

		// Latvian
		'Ä€' => 'A', 'ÄŒ' => 'C', 'Ä’' => 'E', 'Ä¢' => 'G', 'Äª' => 'i', 'Ä¶' => 'k', 'Ä»' => 'L', 'Å…' => 'N',
		'Å ' => 'S', 'Åª' => 'u', 'Å½' => 'Z',
		'Ä' => 'a', 'Ä' => 'c', 'Ä“' => 'e', 'Ä£' => 'g', 'Ä«' => 'i', 'Ä·' => 'k', 'Ä¼' => 'l', 'Å†' => 'n',
		'Å¡' => 's', 'Å«' => 'u', 'Å¾' => 'z'
	);

	// Make custom replacements
	$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

	// Transliterate characters to ASCII
	if ($options['transliterate']) {
		$str = str_replace(array_keys($char_map), $char_map, $str);
	}

	// Replace non-alphanumeric characters with our delimiter
	$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

	// Remove duplicate delimiters
	$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

	// Truncate slug to max. characters
	$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

	// Remove delimiter from ends
	$str = trim($str, $options['delimiter']);

	return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
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
