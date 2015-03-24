<?php

use Model\User;

final class controller extends Controller\baseController
{

	public function __construct ()
	{

		parent::__construct ();

		User::redirectIfSignedIn ();

		$this->template->page[ "title" ] = "Makers, Thinkers and Doers";
		$this->template->page[ "act" ] = 1;

		$this->template->authors = self::generateAuthors ();
		$this->template->schedule = self::generateSchedule();
	}

	private static function generateAuthors ()
	{

		return [
			"James Gill 1" => [ "img" => "james-gill.png" , "position" => "Co-founder &amp; CEO" , "company" => "GoCardless" ] ,
			"James Gill 2" => [ "img" => "james-gill.png" , "position" => "Co-founder &amp; CEO" , "company" => "GoCardless" ] ,
			"James Gill 3" => [ "img" => "james-gill.png" , "position" => "Co-founder &amp; CEO" , "company" => "GoCardless" ]
		];
	}

	private static function generateSchedule ()
	{

		return [
			[ "title" => "Making Products More Human" , "time" => "9.30 - 10.30 am" , "author" => "James Gill 1" ] ,
			[ "title" => "Making Products More Human" , "time" => "9.30 - 10.30 am" , "author" => "James Gill 2" ] ,
			[ "title" => "Making Products More Human" , "time" => "9.30 - 10.30 am" , "author" => "James Gill 3" ]
		];
	}

}
