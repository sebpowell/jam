<?php

final class controller extends Controller\userController
{

	public function __construct()
	{
		parent::__construct();

		$this->user->logout();
	}

}

