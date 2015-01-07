<?php

use Model\User;
use Form\Control as Form;
use Utilities\Http;
use Utilities\Debug;
use Utilities\appException;
use Utilities\Alert;

final class controller extends Controller\baseController
{

	public function __construct ()
	{

		parent::__construct ();

		User::redirectIfSignedIn ();

		$this->template->page[ "title" ] = "Add";
		$this->template->page[ "act" ] = 1;
		//$this->template->page[ "scripts" ] = ["form"];

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

	// OOD implementation to re-gen. individual items from content.json
	private function tempGenContent ()
	{

		$file = file_get_contents ( APP_DIR . "/assets/content/content.json" );

		$content = json_decode ( $file , true );

		foreach ( $content as $k ) {
			$timeStamp = strtotime ( $k[ "date" ] );

			$newJsonName = APP_DIR . "/assets/content/" . $timeStamp . ".json";
			$newJsonContent = json_encode ( $k );

			if ( file_exists ( $newJsonName ) ) {
				Debug::err ( new appException( "Name $newJsonName already exists!" ) );
			} else {
				if ( file_put_contents ( $newJsonName , $newJsonContent ) ) {
					echo "File $newJsonName was successfully created!<br>";
				}
			}
		}
	}

	private function addContent ( $data )
	{

		if ($data["code"] !== "jamissuperawesome") {
			return Alert::render ( "Your secret code is not valid, sorry. Not able to publish anything." , "alert error" );
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
			$m = Alert::render ( "Name $newJsonName already exists!" , "alert error" );
		} else {
			if ( file_put_contents ( $newJsonName , $newJsonContent ) ) {
				$m = Alert::render ( "File $newJsonName was successfully created!<br>" , "alert success" );
			}
		}

		return $m;
	}

	private function assignFormAdd ()
	{

		$form = new Form( "post" , "add" );

		$form->addInput ( "text" , "code" , "App Secret" , false , false , false , [ "required" ] );
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
