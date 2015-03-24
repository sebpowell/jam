<?php

use Model\User;
use Utilities\Http;
use Utilities\Validate;
use Form\Control as Form;

final class controller extends Controller\baseController
{

	public function __construct ()
	{

		parent::__construct ();

		User::redirectIfSignedIn ();

		$this->template->page[ "title" ] = "Makers, Thinkers and Doers";
		$this->template->page[ "act" ] = 1;

		$this->template->authors = self::generateAuthors();
	}

	private static function generateAuthors ()
	{

		return [
			"James Gill" => [ "img" => "james-gill.png" , "position" => "Co-founder &amp; CEO" , "company" => "GoCardless" ] ,
			"James Gill 2" => [ "img" => "james-gill.png" , "position" => "Co-founder &amp; CEO" , "company" => "GoCardless" ] ,
			"James Gill 3" => [ "img" => "james-gill.png" , "position" => "Co-founder &amp; CEO" , "company" => "GoCardless" ]
		];
	}

}
