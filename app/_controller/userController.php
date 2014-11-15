<?php

namespace Controller;

use Db\Control as Db;
use Model\User;

abstract class userController
{

	public function __construct()
	{
		$this->template = new templateController();

		$this->db = Db::getInstance();
		$this->user = new User();

		$ud = $this->user->getData(array(
				"ID", "Name", "Email", "ProfilePicture", "Language"
		));

		$this->template->userData = $ud["data"];
	}

}
