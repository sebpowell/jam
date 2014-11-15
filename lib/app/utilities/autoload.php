<?php

/**
 * Class autoloading function
 * @param string $n
 * @throws Exception
 */
function classAutoload($n)
{
	if (preg_match("/Controller/i", $n)) {
		$class = WWW_APP_DIR . '/_c' . ltrim(str_replace('\\', '/', $n), "C") . '.php';
	}
	elseif (preg_match("/Model/i", $n)) {
		$class = WWW_APP_DIR . '/_' . strtolower(str_replace('\\', '/', $n)) . '.php';
	}
	else {
		$class = LIB_DIR . '/' . strtolower(str_replace('\\', '/', $n)) . '.php';
	}

	if (!require_once $class) {
		throw new Exception("Class $n could not be loaded");
	}
}

spl_autoload_register("classAutoload");
