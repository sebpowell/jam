<?php

namespace Utilities;

class Alert
{

	/**
	 * Renders html formatted alert
	 * @param mixed $r
	 * @param string $cl
	 * @return string
	 */
	public static function render($r, $cl = "alert")
	{
		$a = '';

		if (is_array($r)) {
			foreach ($r as $k)
			{
				$a .= '<div class="' . $cl . '"><p>' . $k . '</p></div>' . BR;
			}
		}
		elseif (is_bool($r) && $r === true) {
			$a .= '<div class="alert success"><p>Well done! You filled out the form successfully.</p></div>' . BR;
		}
		elseif (is_string($r)) {
			$a .= '<div class="' . $cl . '">' . '<p>' . $r . '</p></div>' . BR;
		}
		else {
			$a .= '<div class="alert error"><p>Oh no! An unknown error occured.</p></div>' . BR;
		}

		return $a;
	}

}