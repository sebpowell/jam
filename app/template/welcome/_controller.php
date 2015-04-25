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
			"James Gill"      => [ "img" => "james-gill.png" , "position" => "CEO" , "company" => "GoSquared", "link" => "https://www.gosquared.com/" ] ,
			"Scott Weiss"     => [ "img" => "scott-weiss.jpg" , "position" => "VP Design" , "company" => "SwiftKey", "link" => "http://swiftkey.com/en/" ] ,
			//"Martin Willers"  => [ "img" => "martin-willers.jpg" , "position" => "Founder" , "company" => "PeoplePeople", "link" => "http://www.peoplepeople.se/" ] ,
			"Tim Davey"       => [ "img" => "tim-davey.jpg" , "position" => "Co-Founder &amp; VP Product" , "company" => "OneFineStay", "link" => "http://www.onefinestay.com/" ] ,
			"Graham Paterson" => [ "img" => "graham-paterson.jpg" , "position" => "Product Manager" , "company" => "Transferwise", "link" => "https://transferwise.com/" ],
			"Will Swannell" => [ "img" => "will-swannell.png" , "position" => "Founder & CEO" , "company" => "Hire Space", "link" => "https://hirespace.com/" ],
			"Pip Jamieson" => [ "img" => "pip-jamieson.png" , "position" => "Founder" , "company" => "The Dots", "link" => "https://the-dots.co.uk/" ],
			"To be announced" => [ "img" => "tbc.png" , "position" => "TBC" , "company" => "", "link" => "" ],
			"To be announced " => [ "img" => "tbc.png" , "position" => "TBC" , "company" => "", "link" => "" ],
			" To be announced" => [ "img" => "tbc.png" , "position" => "TBC" , "company" => "", "link" => "" ]
		];
	}

	private static function generateSchedule ()
	{

		return [
			[ "title" => "Nurturing a product-driven culture" , "time" => "10.15 - 10.40 am" , "author" => "Tim Davey" ] ,
			[ "title" => "Deciding what to build" , "time" => "10.15 - 10.45 am" , "author" => "Scott Weiss" ] ,
			[ "title" => "Data-driven design" , "time" => "9.30 - 10.30 am" , "author" => "Martin Willers" ] ,
			[ "title" => "Organising teams for success" , "time" => "9.30 - 10.30 am" , "author" => "James Gill" ] ,
			[ "title" => "Making products more human" , "time" => "9.30 - 10.30 am" , "author" => "Graham Paterson" ], 
			[ "title" => "Learning from hardware design" , "time" => "9.30 - 10.30 am" , "author" => "Graham Paterson" ], 
		];
	}
}









