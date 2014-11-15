<?php

namespace Template;

class jsCompile
{

	/**
	 * Compiles js scripts (used in <head> template)
	 * @param array $i
	 * @param string $p
	 * @return string
	 */
	public static function compile(array $i, $p = "/assets/js/partials")
	{
		$r = '';

		if (DEBUG) {
			foreach ($i as $k)
			{
				$r .= '<script src="' . $p . '/' . $k . '.js"></script>' . BR;
			}
		}
		else {
			$r .= '<script type="text/javascript">';
			foreach ($i as $k)
			{
				$f = APP_DIR . $p . '/' . $k . '.js';
				if (is_file($f) && file_exists($f)) {
					$r .= file_get_contents($f);
				}
			}
			$r .= '</script>' . BR;
		}

		return $r;
	}

}
