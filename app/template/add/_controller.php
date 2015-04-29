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

		$timeStamp = strtotime ( $data[ "date" ] );
		$fileName = String::sanUrl ( $data[ "title" ] );
		$newJsonName = APP_DIR . "/assets/content/" . $fileName . ".json";

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
			$m = Alert::render ( "Name /assets/content/" . $fileName . ".json already exists!" , "alert error" );
		} else {
			if ( file_put_contents ( $newJsonName , $newJsonContent ) ) {
				$m = Alert::render ( "New resource was successfully created!<br>Your link to grab is <strong>http://www.jam2015.london/resources/" . $fileName . "</strong>" , "alert success" );
			}
		}

		return $m;
	}

	private function assignFormAdd ()
	{

		$form = new Form( "post" , "add" );

		$form->addInput ( "text" , "author" , "Author's name" , false , false , false , [ "required" ] );
		$form->addInput ( "text" , "title" , "Title" , false , false , false , [ "required" ] );
		$form->addInput ( "text" , "link" , "Article URL" , false , false , false , [ "required" ] );
		$form->addInput ( "text" , "image" , "Image to go with it" );
		$form->addInput ( "text" , "desc" , "Description" , false , false , false , [ "required" ] );
		$form->addInput ( "text" , "date" , "Date" , date ( "d F Y" ) , false , false , [ "required" ] );
		$form->addInput ( "text" , "tags" , "Comma separated categories" , false , false , false , [ "required" ] );

		$form->addButton ( "dispatch" , "Add resource" , "button primary" );

		$this->form[ "add" ] = $form;
	}

}
