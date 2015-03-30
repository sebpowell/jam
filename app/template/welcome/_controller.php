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
		$this->template->schedule = self::generateSchedule ();
	}

	private static function generateAuthors ()
	{

		return [
			"James Gill"      => [ "img" => "james-gill.jpg" , "position" => "CEO" , "company" => "GoSquared" ] ,
			"Scott Weiss"     => [ "img" => "scott-weiss.jpg" , "position" => "VP Design" , "company" => "SwiftKey" ] ,
			"Martin Willers"  => [ "img" => "martin-willers.jpg" , "position" => "Founder" , "company" => "PeoplePeople" ] ,
			"Tim Davey"       => [ "img" => "tim-davey.jpg" , "position" => "Co-Founder &amp; VP Product" , "company" => "OneFineStay" ] ,
			"Graham Paterson" => [ "img" => "graham-paterson.jpg" , "position" => "Product Manager" , "company" => "Transferwise" ]
		];
	}

	private static function generateSchedule ()
	{

		return [
			[ "title" => "Making Products More Human" , "time" => "9.30 - 10.30 am" , "author" => "James Gill" ] ,
			[ "title" => "Making Products More Human" , "time" => "9.30 - 10.30 am" , "author" => "Scott Weiss" ] ,
			[ "title" => "Making Products More Human" , "time" => "9.30 - 10.30 am" , "author" => "Martin Willers" ] ,
			[ "title" => "Making Products More Human" , "time" => "9.30 - 10.30 am" , "author" => "Tim Davey" ] ,
			[ "title" => "Making Products More Human" , "time" => "9.30 - 10.30 am" , "author" => "Graham Paterson" ]
		];
	}

}
