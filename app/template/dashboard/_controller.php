<?php

use Utilities\Http;
use Form\Control as Form;
use Model\User;

final class controller extends Controller\userController
{

	private $form;

	public function __construct()
	{
		parent::__construct();

		$this->template->page["title"] = "Welcome";
		$this->template->page["scripts"] = array("form");

		$this->assignEditProfileForm();

		if (isset($this->template->page["url"]["param"])) {
			$this->template->parseParam(array("user", "ID", 1, 11));
			$this->assignRemoteUserData();
		}

		$this->template->randomProfile = $this->returnRandomProfile();
		$this->template->formEditProfile = $this->form["editProfile"]->render();

		if (Http::isRequest("execute")) {
			$post = Http::getPost();

			$v = $this->form["editProfile"]->validate($post);
			$img = ($_FILES["profilePicture"]["size"] > 0) ? $_FILES["profilePicture"] : false;

			if ($v === true) {
				$this->template->alertEditProfile = User::update(array(
										"Name" => array($post["name"], 2, 128),
										"Email" => array($post["email"], 2, 128),
										"Language" => array($post["language"], 1, 2),
												), $this->template->userData["ID"], $img);
			}
			else {
				$this->template->alertEditProfile = $v;
			}
		}
	}

	/**
	 * Assigns edit profile form
	 */
	private function assignEditProfileForm()
	{
		$form = new Form("post", "editProfile", false, "multipart/form-data");

		$form->addFileInput("profilePicture", "Choose your profile picture", false, 2097152);
		$form->html .= "<hr>";
		$form->addInput("text", "name", "Full name", $this->template->userData["Name"], false, false, array("required"));
		$form->addInput("email", "email", "E-mail", $this->template->userData["Email"], false, false, array("required", "email"));
		$form->html .= "<hr>";
		$form->addSelect("language", array(1 => "English", 2 => "Français"), $this->template->userData["Language"], false, array("required", "select"), "Choose language");
		$form->addButton("execute", "Save changes", "button-primary");

		$this->form["editProfile"] = $form;
	}

	/**
	 * Returns randomly generated user ID
	 * @return int
	 */
	private function returnRandomProfile()
	{
		$c = (int) $this->db->exec("SELECT COUNT(ID) FROM user ORDER BY ID DESC", false, "fetchColumn");
		return rand(1, $c);
	}

	/**
	 * Assigns remote user data
	 */
	private function assignRemoteUserData()
	{
		$ur_d = $this->db->get(array("Name", "Email", "uID"), "user", array("ID", $this->template->page["url"]["param"], 1, 11));

		if (isset($ur_d["data"]["uID"])) {
			$ur_d["data"]["uIDdecoded"] = User::uIDdecrypt($ur_d["data"]["uID"]);
		}

		$this->template->userRemoteData = $ur_d["data"];
	}

}
