<?php

use Model\User;

final class controller extends Controller\baseController
{

	public function __construct()
	{
		parent::__construct();

		User::redirectIfSignedIn();

		$this->template->page["title"] = "Manifesto";
		$this->template->page["act"] = 1;

		$this->template->theTeam = $this->renderTeamMembers();
	}

	private function renderTeamMembers() {
		$team = [
			[
				"name" => "Seb Powell",
				"photo" => "seb-powell.png",
				"desc" => "Head of Design. Amateur developer.",
				"linkedin" => "sebastienpowell",
				"twitter" => "sebpowell"
			],
			[
				"name" => "Slavo Vojacek",
				"photo" => "slavo-vojacek.png",
				"desc" => "UX Designer &amp; Developer. Lover of fine English literature.",
				"linkedin" => "slavomirvojacek",
				"twitter" => "slavomirvojacek"
			],
			[
				"name" => "Mathilde Leo",
				"photo" => "mathilde-leo.png",
				"desc" => "Product Owner. Martial arts aficionado.",
				"linkedin" => "mathildeleo",
				"twitter" => "Mathilde_Leo"
			]
		];

		shuffle($team);

		return $team;
	}

}
