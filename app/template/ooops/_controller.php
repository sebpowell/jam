<?php

final class controller extends Controller\baseController
{

	public function __construct()
	{
		parent::__construct();

		$this->template->page["title"] = "Ooops!";
	}

}

