<?php

namespace Utilities;

/**
 * Thrown when a database-related error occurs
 */
class dbException extends \Exception
{

	public function __construct($message, $code = 0)
	{
		parent::__construct($this->formatException($message), $code, null);
	}

	private function formatException($m)
	{
		return "Database error! " . $m;
	}

}