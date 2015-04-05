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
			"Graham Paterson" => [ "img" => "graham-paterson.jpg" , "position" => "Product Manager" , "company" => "Transferwise" ],
			"Bob" => [ "img" => "graham-paterson.jpg" , "position" => "Product Manager" , "company" => "1" ],
			"Joe" => [ "img" => "graham-paterson.jpg" , "position" => "Product Manager" , "company" => "Transferwise" ],
			"Ben" => [ "img" => "graham-paterson.jpg" , "position" => "Product Manager" , "company" => "Transferwise" ],
			"Simon" => [ "img" => "graham-paterson.jpg" , "position" => "Product Manager" , "company" => "Transferwise" ]
		];
	}

	private static function generateSchedule ()
	{

		return [
			[ "title" => "How different functions collaborate for success?" , "time" => "10.15 - 10.40 am" , "author" => "Tim Davey" ] ,
			[ "title" => "Reinventing the phone keyboard" , "time" => "10.15 - 10.45 am" , "author" => "Scott Weiss" ] ,
			[ "title" => "Building hardware" , "time" => "9.30 - 10.30 am" , "author" => "Martin Willers" ] ,
			[ "title" => "Better product decisions" , "time" => "9.30 - 10.30 am" , "author" => "James Gill" ] ,
			[ "title" => "Product-centric Culture" , "time" => "9.30 - 10.30 am" , "author" => "Graham Paterson" ]
		];
	}

}
