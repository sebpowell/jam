<?php

namespace Controller;

abstract class baseController
{

	public function __construct()
	{
		$this->template = new templateController();
	}

}

