<?php

use Model\User;

final class controller extends Controller\baseController
{

	public function __construct()
	{
		parent::__construct();

		User::redirectIfSignedIn();

		$this->template->page["title"] = "Blog";
		$this->template->page["act"] = 1;

		$this->getContent();
	}

	private function getContent() {
		$file = file_get_contents(APP_DIR . "/assets/content/content.json");

		$content = json_decode($file, true);

		$this->template->content = $content;
	}

}
