<?php

namespace Form;

use Utilities\Alert;
use Utilities\String;
use Utilities\Validate;
use Utilities\Debug;
use Utilities\appException;
use Utilities\inputException;

class Control
{

	/**
	 * Allowed input types
	 * @var array
	 */
	private $a_t = array("button", "checkbox", "color", "date", "datetime", "datetime-local", "email", "file", "hidden", "image", "month", "number", "password", "radio", "range", "reset", "search", "submit", "tel", "text", "time", "url", "week");

	/**
	 * Allowed form methods
	 * @var array
	 */
	private $a_m = array("post", "get");

	/**
	 * Form ID
	 * @var string
	 */
	private $id;

	/**
	 * Form inputs
	 * @var array
	 */
	private $inputs;

	/**
	 * Form selects
	 * @var array
	 */
	private $selects;

	/**
	 * Forms textareas
	 * @var array
	 */
	private $textareas;

	/**
	 * Forms buttons
	 * @var array
	 */
	private $buttons;

	/**
	 * Actual form in HTML
	 * @var string
	 */
	public $html;

	/**
	 * Errors
	 * @var array
	 */
	private static $errors = array(
			"required" => "Please, fill out all required fields.",
			"email" => "Please, enter a valid e-mail address.",
			"name" => "Please, enter a valid form of name.",
			"int" => "Please, enter a valid integer value.",
			"numeric" => "Please, enter a valid numeric value.",
			"string" => "Please, enter a valid string value.",
			"password" => "Your password must be at least 6 characters long and contain at least one number.",
			"select" => "You must select an option from the list.",
	);

	/**
	 * Form constructor
	 * @param string $m
	 * @param string $id
	 * @param string | boolean $cl
	 * @param string | boolean $e
	 * @param boolean $ac
	 */
	public function __construct($m, $id, $cl = false, $e = false, $ac = true)
	{
		if (empty($id) || !in_array($m, $this->a_m) || !is_bool($e)) {
			Debug::err(new inputException(__METHOD__));
		}

		$this->id = $id;
		$this->inputs = array();
		$this->selects = array();
		$this->textareas = array();
		$this->buttons = array();

		$this->html = '<form' . (!$ac ? ' autocomplete="off"' : '') . ($cl ? ' class="' . $cl . '"' : "") . ' method="' . $m . '" id="form-' . strtolower($this->id) . '"' . ($e ? ' enctype="multipart/form-data"' : '') . '>' . BR;
		$this->html .= '<div class="flash-message"></div>' . BR;
	}

	/**
	 * Renders the form container
	 * @return string
	 */
	public function render()
	{
		return $this->html . '</form>' . BR;
	}

	/**
	 * Validates post values
	 * @param array $i
	 * @return boolean | string
	 */
	public function validate(array $i)
	{
		$p = array();
		$r = array();
		$d = array_merge($this->selects, $this->textareas, $this->inputs, $this->buttons);

		foreach ($i as $k => $v)
		{
			if (!in_array($k, array_keys($d))) {
				Debug::err(new inputException(__METHOD__ . " Key $k not found!"));
				return false;
			}

			$p[$k] = $v;
		}

		foreach ($d as $k => $v)
		{
			if (isset($p[$k]) && is_array($v)) {
				$val = $p[$k];
				$rule = $v;

				if (in_array("required", $rule) && empty($val)) {
					$r[] = "Please, fill out the <strong>$k</strong> input.";
				}
				if (in_array("email", $rule) && Validate::email($val) !== true) {
					if (!in_array("required", $rule) && !empty($val) || in_array("required", $rule)) {
						$r[] = "Invalid e-mail value <strong>&quot;" . String::san($val) . "&quot;</strong>.";
					}
				}
				if (in_array("password", $rule) && Validate::password($val) !== true) {
					if (!in_array("required", $rule) && !empty($val) || in_array("required", $rule)) {
						$r[] = "Your password must contain a minimum of 6 characters and at least one number.";
					}
				}
				if (in_array("hash", $rule) && Validate::hash($val) !== true) {
					if (!in_array("required", $rule) && !empty($val) || in_array("required", $rule)) {
						$r[] = "Invalid input data in <strong>&quot;$k&quot;</strong> input.";
					}
				}
				if (in_array("name", $rule) && Validate::name($val) !== true) {
					if (!in_array("required", $rule) && !empty($val) || in_array("required", $rule)) {
						$r[] = "Invalid name value <strong>&quot;" . String::san($val) . "&quot;</strong>.";
					}
				}
				if (in_array("string", $rule) && !is_string($val)) {
					if (!in_array("required", $rule) && !empty($val) || in_array("required", $rule)) {
						$r[] = "Value <strong>&quot;" . String::san($val) . "&quot;</strong> is not a string.";
					}
				}
				if (in_array("numeric", $rule) && !is_numeric($val)) {
					if (!in_array("required", $rule) && !empty($val) || in_array("required", $rule)) {
						$r[] = "Value <strong>&quot;" . String::san($val) . "&quot;</strong> is not numeric.";
					}
				}
				if (in_array("int", $rule) && !is_int($val)) {
					if (!in_array("required", $rule) && !empty($val) || in_array("required", $rule)) {
						$r[] = "Value <strong>&quot;" . String::san($val) . "&quot;</strong> is not an integer.";
					}
				}
				if (isset($rule["rule"]) && in_array("select", $rule["rule"])) {
					$sel = $this->selects[$k]["options"];

					if (!in_array($val, array_keys($sel))) {
						if (!in_array("required", $rule["rule"]) && !empty($val) || in_array("required", $rule["rule"])) {
							$r[] = "Invalid select value <strong>&quot;" . String::san($val) . "&quot;</strong>.";
						}
					}
				}
			}
		}

		if (count($r) > 0) {
			return Alert::render($r);
		}

		return true;
	}

	/**
	 * Parses rules into json form
	 * @param array $r
	 * @return string
	 */
	private static function parseRules(array $r)
	{
		$jsRule = '';
		foreach ($r as $k)
		{
			if ($k !== "required") {
				$jsRule .= 'data-rule=\'{"' . $k . '":"' . static::$errors[$k] . '"}\'';
			}
		}

		return $jsRule;
	}

	/**
	 * Adds input
	 * @param string $t
	 * @param string $n
	 * @param boolean | string $p
	 * @param boolean | string $v
	 * @param boolean $a
	 * @param boolean | string $cl
	 * @param array | boolean $rule
	 * @return boolean | string
	 */
	public function addInput($t, $n, $p = false, $v = false, $a = false, $cl = false, $rule = false)
	{
		if (!in_array($t, $this->a_t) || empty($n)) {
			Debug::err(new inputException(__METHOD__));
			return false;
		}

		$r = '<input';
		$r .= ' type="' . $t . '"';
		$r .= ' name="' . $n . '"';
		$r .= $p && is_string($p) ? ' placeholder="' . $p . '"' : '';
		$r .= $cl ? ' class="' . $cl . '"' : '';
		$r .= $v ? ' value="' . String::san($v) . '"' : '';
		$r .= $a ? ' autofocus' : '';
		$r .= $t == "date" ? ' min="' . $p[0] . '" max="' . $p[1] . '"' : '';
		$r .= $rule && in_array("required", $rule) ? ' required' : '';
		$r .= $rule ? ' ' . self::parseRules($rule) : '';
		$r .= '>' . BR;

		$this->nameExists($n);

		$this->inputs[$n] = $rule;
		$this->html .= $r;
	}

	/**
	 * Adds select
	 * @param string $n
	 * @param array $d
	 * @param mixed $s
	 * @param boolean | string $cl
	 * @param array | boolean $rule
	 * @return boolean | string
	 */
	public function addSelect($n, $d, $s = false, $cl = false, $rule = false, $ch = false)
	{
		if (empty($n) || !is_array($d) || $s && !in_array($s, array_keys($d))) {
			Debug::err(new inputException(__METHOD__));
			return false;
		}

		$r = '<select';
		$r .= $rule && in_array("required", $rule) ? ' required' : '';
		$r .= ' name="' . $n . '" class="';
		$r .= ($rule && in_array("required", $rule)) ? 'required' : '';
		$r .= $cl ? ' ' . $cl : '';
		$r .= '">';
		$r .= '<option value="">--- ';
		$r .= ($ch) ? $ch : 'Choose';
		$r .= '---</option>' . BR;
		foreach ($d as $k => $v)
		{
			$r .= '<option value="' . String::san($k) . '"';
			if ($s and $s == $k) {
				$r .= ' selected';
			}
			$r .= '>' . String::san($v) . '</option>' . BR;
		}
		$r .= '</select>' . BR;

		$this->nameExists($n);

		$this->selects[$n] = array("rule" => $rule, "options" => $d);
		$this->html .= $r;
	}

	/**
	 * Adds textarea
	 * @param string $n
	 * @param boolean | string $p
	 * @param boolean | string $v
	 * @param boolean $a
	 * @param boolean | string $cl
	 * @param array | boolean $rule
	 * @return boolean | string
	 */
	public function addTextarea($n, $p = false, $v = false, $a = false, $cl = false, $rule = false)
	{
		if (empty($n)) {
			Debug::err(new inputException(__METHOD__));
			return false;
		}

		$r = '<textarea';
		$r .= ' name="' . $n . '"';
		$r .= $p ? ' placeholder="' . $p . '"' : '';
		$r .= $cl ? ' class="' . $cl . '"' : '';
		$r .= $a ? ' autofocus' : '';
		$r .= $rule && in_array("required", $rule) ? ' required' : '';
		$r .= $rule ? ' ' . self::parseRules($rule) : '';
		$r .= '>';
		$r .= $v ? String::san($v) : '';
		$r .= '</textarea>' . BR;

		$this->nameExists($n);

		$this->textareas[$n] = $rule;
		$this->html .= $r;
	}

	/**
	 * Adds button
	 * @param string $n
	 * @param string $v
	 * @param boolean | string $cl
	 * @return boolean | string
	 */
	public function addButton($n, $v, $cl = false)
	{
		if (empty($n) || empty($v)) {
			Debug::err(new inputException(__METHOD__));
			return false;
		}

		$r = '<button class="';
		$r .= $cl ? $cl : '';
		$r .= '" name="' . $n . '" id="button-' . strtolower($n) . '">';
		$r .= String::san($v);
		$r .= '</button>' . BR;

		$this->nameExists($n);

		$this->buttons[$n] = true;
		$this->html .= $r;
	}

	/**
	 * Adds specific (file type) input
	 * @param string $n
	 * @param string $v
	 * @param boolean $m
	 * @param array | boolean $rule
	 * @return boolean | string
	 */
	public function addFileInput($n, $v = "Choose", $m = false, $max = 20971520, $rule = false)
	{
		if (empty($n) || empty($v) || !is_bool($m)) {
			Debug::err(new inputException(__METHOD__));
			return false;
		}

		$r = '<div class="file-button"><div class="button button-primary">' . String::san($v) . '</div>';
		$r .= '<input type="hidden" name="UPLOAD_IDENTIFIER" value="' . md5(time() . rand()) . '">' . BR;
		$r .= '<input type="file" id="' . $n . '" name="' . $n;
		$r .= $m ? '[]' : '';
		$r .= '"';
		$r .= $m ? ' multiple' : '';
		$r .= $rule && in_array("required", $rule) ? ' required' : '';
		$r .= '>' . BR;
		$r .= '<input type="hidden" name="MAX_FILE_SIZE" value="' . (int) $max . '">';
		$r .= '</div>' . BR;

		$this->nameExists($n);

		$this->inputs["UPLOAD_IDENTIFIER"] = $rule;
		$this->inputs["MAX_FILE_SIZE"] = $rule;
		$this->inputs[$n] = $rule;
		$this->html .= $r;
	}

	/**
	 * Checks whether input/textarea/button
	 * name is already in use
	 * @param string $n
	 * @return boolean
	 */
	private function nameExists($n)
	{
		if (in_array($n, array_keys($this->inputs)) || in_array($n, array_keys($this->textareas)) || in_array($n, array_keys($this->selects)) || in_array($n, array_keys($this->buttons))) {
			Debug::err(new appException("The name $n already exists in current form"));
		}

		return true;
	}

}
