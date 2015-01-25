<?php

use Model\User;
use Utilities\Http;
use Utilities\Validate;
use Template\Url;
use Form\Control as Form;

final class controller extends Controller\baseController
{

	public function __construct ()
	{

		parent::__construct ();

		User::redirectIfSignedIn ();

		$this->template->page[ "title" ] = "Makers, Thinkers and Doers";
		$this->template->page[ "act" ] = 1;

		$this->template->content = [];
		$this->map = [];

		$this->getContent ();

		if ( isset( $this->template->page[ "url" ][ "param" ] ) ) {
			$this->template->resourceDetails = [];

			$this->template->parseParam ( $this->map );

			$this->loadResourceDetails ();
			$this->assignMeta ();
		}
	}

	private function loadResourceDetails ()
	{

		$fileContents = file_get_contents ( APP_DIR . "/assets/content/" . $this->template->page[ "url" ][ "param" ] . ".json" );
		$this->template->resourceDetails = json_decode ( $fileContents , true );
	}

	private function getContent ()
	{

		$data = [ ];

		$contentsDir = APP_DIR . "/assets/content";
		$f = glob ( $contentsDir . "/*" );

		foreach ( $f as $path ) {
			// This gets the file name from the current file path.
			$fileName = basename ( $path , ".json" );

			$fileContents = file_get_contents ( $path );
			$content = json_decode ( $fileContents , true );
			$contentTimestamp = strtotime ($content["date"]);

			$today = strtotime ( date ( "d F Y" ) );

			if ( $contentTimestamp <= $today ) {
				array_push($this->map, $fileName);
				$data[ $contentTimestamp ] = $content;
			}
		}

		krsort ( $data );

		$this->template->content = $data;
	}

	private function assignMeta ()
	{

		$this->template->omTitle = trim ( $this->template->resourceDetails[ "title" ] );
		$this->template->omDescription = trim ( $this->template->resourceDetails[ "desc" ] );
		$this->template->omUrl = Url::returnBaseUrl () . "/" . $this->template->page[ "url" ][ "template" ] . "/" . $this->template->page[ "url" ][ "param" ];
		$this->template->omImage = isset ( $this->template->resourceDetails[ "image" ] ) ? trim ( $this->template->resourceDetails[ "image" ] ) : false;
	}

}
