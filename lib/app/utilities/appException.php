<?php

namespace Utilities;

/**
 * Thrown when an internal error occurs
 */
class appException extends \Exception
{

	public function __construct($message, $code = 0)
	{
		parent::__construct($this->formatException($message), $code, null);
	}

	private function formatException($m)
	{
		return "Application (internal) error! " . $m;
	}

}