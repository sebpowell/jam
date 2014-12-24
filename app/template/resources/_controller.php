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

		$this->getContent ();
	}

	private function getContent ()
	{

		$file = file_get_contents ( APP_DIR . "/assets/content/content.json" );

		$contentRaw = json_decode ( $file , true );

		foreach($contentRaw as $k => $v) {
			$time = strtotime ( $v[ "date" ] );
			if ($time > time()) {
				// do nothing
			} else {
				$content[$time] = $v;
			}
		}

		krsort($content);

		$this->template->content = $content;
	}

}
