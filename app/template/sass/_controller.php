<?php

use Model\User;

final class controller extends Controller\baseController
{

	public function __construct()
	{
		parent::__construct();

		User::redirectIfSignedIn();

		$this->template->page["title"] = "CSS";
		$this->template->page["act"] = 1;
	}

}