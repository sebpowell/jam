<?php

include "check.php";

define("DEBUG", true);
define("GRID", false);

define("WWW_APP_DIR", APP_DIR . "/app");
define("CONTENT_DIR", APP_DIR . "/assets/content");
define("UPLOAD_DIR", APP_DIR . "/temp");
define("BR", PHP_EOL);

/**
 * Change the values below immediately
 */
define("AES_128_PASS", md5("secretPassword", true));
define("AES_128_IV", "ecgf7h2pz89089b2");

/**
 * Error reporting
 */
if (DEBUG) {
	error_reporting(E_ALL);
	ini_set("display_errors", E_ALL);
}
else {
	error_reporting(0);
}

/**
 * Initialise autoloader
 */
require_once LIB_DIR . "/utilities/autoload.php";

$app = array_merge(Utilities\Neon::decode(file_get_contents(APP_DIR . "/_config/app.neon")), $usage);

date_default_timezone_set($app["dateTime"]);

mb_internal_encoding($app["encoding"]);
mb_http_output($app["encoding"]);


ini_set("session.cookie_httponly", 1);
ini_set("session.hash_function", "whirlpool");

ini_set("upload_max_filesize", "20M");
ini_set("post_max_size", "20M");
ini_set("max_input_time", 180);
ini_set("max_execution_time", 180);
set_time_limit(180);

/**
 * Go!
 */
$tmp = new Template\Template;
$tmp->run();
