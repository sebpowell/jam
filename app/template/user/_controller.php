<?php

use Form\Control as Form;
use Utilities\Http;
use Utilities\Debug;
use Utilities\appException;
use Template\Url;
use Model\User;

final class controller extends Controller\baseController
{

	private $form;

	public function __construct()
	{
		parent::__construct();

		User::redirectIfSignedIn();

		if (isset($this->template->page["url"]["param"])) {
			$this->template->parseParam();
		}
		else {
			Debug::err(new appException("This page requires a parameter!"));
			Http::redirect(Url::href(array("ooops")));
		}

		$this->template->page["title"] = $this->getTitle();
		$this->template->page["act"] = $this->getAct();
		$this->template->page["scripts"] = array("form");

		/**
		 * Assigns forms
		 */
		$this->assignFormSignIn();
		$this->assignFormSignUp();

		$this->template->formSignIn = $this->form["signIn"]->render();
		$this->template->formSignUp = $this->form["signUp"]->render();


		/**
		 * A request to sign in
		 */
		if (Http::isRequest("signIn")) {
			$post = Http::getPost();

			$v = $this->form["signIn"]->validate($post);

			if ($v === true) {
				$this->template->alertSignIn = User::login($post["email"], $post["password"]);
			}
			else {
				$this->template->alertSignIn = $v;
			}
		}

		/**
		 * A request to sign up
		 */
		if (Http::isRequest("signUp")) {
			$post = Http::getPost();

			$v = $this->form["signUp"]->validate($post);

			if ($v === true) {
				$p = User::encryptPassword($post["password"]);

				$this->template->alertSignUp = User::register(
												array("table" => "user",
														"data" => array(
																"Name" => array(":name" => array($post["name"], 2, 128)),
																"Salt" => array(":salt" => array($p["salt"], 2, 128)),
																"Language" => array(":language" => array($post["language"], 1, 1)),
																"Email" => array(":email" => array($post["email"], 2, 128)),
																"Password" => array(":password" => array($p["password"], 2, 256)),
																"Created" => array(":created" => array(time(), 1, 11))
														))
				);
			}
			else {
				$this->template->alertSignUp = $v;
			}
		}
	}

	/**
	 * Returns title
	 * @return string
	 */
	private function getTitle()
	{
		switch ($this->template->page["url"]["param"])
		{
			case "sign-up": return "Sign up";
			case "sign-in": return "Sign in";
			default: return "Page";
		}
	}

	/**
	 * Returns active menu item number
	 * @return string
	 */
	private function getAct()
	{
		switch ($this->template->page["url"]["param"])
		{
			case "sign-up": return 2;
			case "sign-in": return 3;
			default: return 0;
		}
	}

	/**
	 * Assigns sign in form
	 */
	private function assignFormSignIn()
	{
		$form = new Form("post", "signIn");
		$form->addInput("email", "email", "Your e-mail", false, false, "block", array("required", "email"));
		$form->addInput("password", "password", "Your password", false, false, "block", array("required"));
		$form->addButton("signIn", "Sign me in!", "button-secondary");

		$this->form["signIn"] = $form;
	}

	/**
	 * Assigns sign up form
	 */
	private function assignFormSignUp()
	{
		$form = new Form("post", "signUp");
		$form->addInput("text", "name", "Your full name", false, false, "block", array("required", "name"));
		$form->addInput("email", "email", "Your e-mail", false, false, "block", array("required", "email"));
		$form->addInput("password", "password", "Your password", false, false, "block", array("required", "password"));
		$form->addSelect("language", array(1 => "English", 2 => "Français"), 1, "block", array("required", "select"), "Choose language");
		$form->addButton("signUp", "Sign me up!", "button-secondary");

		$this->form["signUp"] = $form;
	}

}
