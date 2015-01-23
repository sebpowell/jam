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

		if ( isset( $this->template->page[ "url" ][ "param" ] ) ) {
			$this->returnPossibleParams();

			$this->template->parseParam (array_keys($this->map));

			$this->loadResourceDetails();
		}

		$this->template->page[ "title" ] = "Makers, Thinkers and Doers";
		$this->template->page[ "act" ] = 1;

		$this->getContent ();
	}

	private function loadResourceDetails() {
		$fileKey = $this->map[$this->template->page[ "url" ][ "param" ]];

		$fileContents = file_get_contents ( APP_DIR . "/assets/content/" . $fileKey . ".json" );
		$this->template->resourceDetails = json_decode ( $fileContents, true );
	}

	private function returnPossibleParams ()
	{

		$mapFile = file_get_contents ( APP_DIR . "/assets/content/map.json" );
		$this->map = json_decode ( $mapFile, true );
	}

	private function getContent ()
	{

		$data = [ ];

		$contentsDir = APP_DIR . "/assets/content";
		$f = glob ( $contentsDir . "/*" );

		foreach ( $f as $path ) {
			// This gets the file name from the current file path.
			$fileName = (int) basename ( $path , ".json" );

			if ($fileName !== 0) {

				$today = strtotime ( date ( "d F Y" ) );

				if ( $fileName <= $today ) {
					$fileContents = file_get_contents ( $path );
					$content = json_decode ( $fileContents , true );

					$data[ $fileName ] = $content;
				}

			}
		}

		krsort ( $data );

		$this->template->content = $data;
	}

}
