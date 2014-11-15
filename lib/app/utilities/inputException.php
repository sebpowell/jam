<?php

namespace Utilities;

/**
 * Thrown when invalid input is passed to a function
 */
class inputException extends \Exception
{

	public function __construct($message, $code = 0)
	{
		parent::__construct($this->formatException($message), $code, null);
	}

	private function formatException($m)
	{
		return "Input error! Invalid arguments passed to " . $m;
	}

}