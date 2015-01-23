<?php

use Model\User;
use Form\Control as Form;
use Utilities\Http;
use Utilities\String;
use Utilities\Alert;

final class controller extends Controller\baseController
{

	public function __construct ()
	{

		parent::__construct ();

		User::redirectIfSignedIn ();

		$this->template->page[ "title" ] = "Add";
		$this->template->page[ "act" ] = 1;

		$this->assignFormAdd ();

		$this->template->formAdd = $this->form[ "add" ]->render ();

		// If the add resource form is dispatched
		if ( Http::isRequest ( "dispatch" ) ) {
			$post = Http::getPost ();
			$v = $this->form[ "add" ]->validate ( $post );

			if ( $v === true ) {
				$this->template->alertAdd = $this->addContent ( $post );
			} else {
				$this->template->alertAdd = $v;
			}
		}

	}

	private function addContent ( $data )
	{

		if ( $data[ "code" ] !== "jamisawesome" ) {
			return Alert::render ( "Your secret code is not valid, sorry. I am not going to publish anything." , "alert error" );
		}

		$timeStamp = strtotime ( $data[ "date" ] );
		$newJsonName = APP_DIR . "/assets/content/" . $timeStamp . ".json";

		$categories = explode ( "," , $data[ "tags" ] );
		$categoriesCleansed = array_map ( function ( $item ) {

			return trim ( $item );
		} , $categories );

		// Gets rid of redundant entries
		unset( $data[ "dispatch" ] );
		unset( $data[ "code" ] );

		$newContent = $data;
		$newContent[ "tags" ] = $categoriesCleansed;

		$newJsonContent = json_encode ( $newContent , JSON_PRETTY_PRINT );

		if ( file_exists ( $newJsonName ) ) {
			$m = Alert::render ( "Name /assets/content/" . $timeStamp . ".json already exists!" , "alert error" );
		} else {
			if ( file_put_contents ( $newJsonName , $newJsonContent ) ) {
				if ($this->createMap ( $data[ "title" ] , $timeStamp )) {
					$m = Alert::render ( "File /assets/content/" . $timeStamp . ".json was successfully created!<br>Your link to grab is <strong>http://www.jam2015.london/resources/" . String::sanUrl($data["title"]) . "</strong>" , "alert success" );
				} else {
					$m = Alert::render ( "Error creating a Key - Value store!" , "alert error" );
				}
			}
		}

		return $m;
	}

	private function createMap ( $newTitle , $newTimeStamp )
	{

		$contentsDir = APP_DIR . "/assets/content";
		$f = glob ( $contentsDir . "/*" );

		foreach ( $f as $path ) {
			$fileName = (int) basename ( $path , ".json" );

			if ($fileName !== 0) {
				$fileContents = file_get_contents ( $path );
				$content = json_decode ( $fileContents , true );

				$key = String::sanUrl ( $content[ "title" ] );
				$value = $fileName;

				$data[ $key ] = $value;
			}
		};

		$newKey = String::sanUrl ( $newTitle );
		$newValue = $newTimeStamp;

		$data[ $newKey ] = $newValue;

		$newJsonContent = json_encode ( $data , JSON_PRETTY_PRINT );

		if ( file_put_contents ( $contentsDir . "/map.json" , $newJsonContent ) ) {
			return true;
		}

		return false;
	}

	private function assignFormAdd ()
	{

		$form = new Form( "post" , "add" );

		$form->addInput ( "password" , "code" , "App Secret" , false , false , false , [ "required" ] );
		$form->addInput ( "text" , "author" , "Author's name" , false , false , false , [ "required" ] );
		$form->addInput ( "text" , "title" , "Title" , false , false , false , [ "required" ] );
		$form->addInput ( "text" , "link" , "Article URL" , false , false , false , [ "required" ] );
		$form->addInput ( "text" , "desc" , "Description" , false , false , false , [ "required" ] );
		$form->addInput ( "text" , "date" , "Date" , date ( "d F Y" ) , false , false , [ "required" ] );
		$form->addInput ( "text" , "tags" , "Comma separated categories" , false , false , false , [ "required" ] );

		$form->addButton ( "dispatch" , "Add resource" , "button primary" );

		$this->form[ "add" ] = $form;
	}

}
