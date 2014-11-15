<?php

namespace Utilities;

use ZipArchive as Zip;

class Upload
{

	/**
	 * File name
	 * @var string | array
	 */
	private $name;

	/**
	 * File type
	 * @var string | array
	 */
	private $type;

	/**
	 * File tmp_name
	 * @var string | array
	 */
	private $tmp_name;

	/**
	 * File error
	 * @var string | array
	 */
	private $error;

	/**
	 * File size
	 * @var string | array
	 */
	private $size;

	/**
	 * Upload directory
	 * @var string
	 */
	private $path = UPLOAD_DIR;

	/**
	 * Maximum upload size (20 MB default)
	 * @var int
	 */
	private $maxSize;

	/**
	 * Maximum number of files per upload
	 * @var int
	 */
	private $maxFiles;

	/**
	 * Desired file name
	 * @var boolean | string
	 */
	private $fileName;

	/**
	 * Allowed extensions
	 * @var array
	 */
	private static $allowedExtensions = array(0 => "png", 1 => "jpg", 2 => "txt", 3 => "zip", 4 => "rar", 5 => "bmp", 6 => "doc", 7 => "xlsx", 8 => "xltx", 9 => "potx", 10 => "ppsx", 11 => "pptx", 12 => "sldx", 13 => "docx", 14 => "dotx", 15 => "xlam", 16 => "xlsb", 17 => "gif", 18 => "odt", 19 => "ott", 20 => "oth", 21 => "odm", 22 => "odg", 23 => "otg", 24 => "odp", 25 => "otp", 26 => "ods", 27 => "ots", 28 => "odc", 29 => "odf", 30 => "odb", 31 => "odi", 32 => "oxt", 33 => "pdf", 34 => "rtf", 35 => "mp3", 36 => "mp4", 37 => "mov", 38 => "avi", 39 => "xla", 40 => "xls", 41 => "xlt", 42 => "xlw", 43 => "pot", 44 => "pps", 45 => "ppt");

	/**
	 * Errors
	 * @var array
	 */
	private static $errors = array(
			"checkFiles" => array(
					"directoryInvalid" => "Ooops! Upload directory does not exist.",
					"errExtension" => "Ooops! We do not allow such files to be uploaded to our servers: ",
					"errUnknown" => "Ooops! An unknown error occured, please, try again."
			),
			"uploadFile" => array(
					"fileExists" => "Ooops! It seems this file already exists, please, try renaming your file.",
					"unknown" => "Ooops! An unknown error occured, please, try again."
			),
			"uploadFiles" => array(
					"unknown" => "Ooops! An unknown error occured, please, try again.",
					"maxFiles" => "Ooops! It seems you are trying to upload too many files at once.",
					"success" => "Well done! Uploading your files was successfull."
			)
	);

	public function __construct($f, $fn = false, $p = false, $ms = 20971520, $mf = 5)
	{
		$this->name = $f["name"];
		$this->type = $f["type"];
		$this->tmp_name = $f["tmp_name"];
		$this->error = $f["error"];
		$this->size = $f["size"];
		$this->maxSize = $ms;
		$this->maxFiles = $mf;
		$this->fileName = $fn;

		if ($p) {
			$this->path = $p;
		}
	}

	/**
	 * Validates files
	 * @return boolean
	 */
	private function checkFiles()
	{
		if (!is_dir($this->path)) {
			Debug::err(new appException("Upload directory does not exist!"));
			return Alert::render(static::$errors[__FUNCTION__]["directoryInvalid"], "alert error");
		}
		if (!$this->fileName) {
			Debug::err(new appException("Filename not set!"));
			return Alert::render(static::$errors[__FUNCTION__]["errUnknown"], "alert error");
		}

		if ($this->isMultiple()) {
			foreach ($this->error as $e)
			{
				if ($e > 0) {
					Debug::err(new inputException(__METHOD__ . " err: " . current($this->error)));
					return Alert::render(static::codeToMessage(current($this->error)), "alert error");
				}

				$ft = self::getFileType(current($this->name));
				if (!is_int($ft)) {
					Debug::err(new inputException(__METHOD__ . " extension: " . $ext));
					return Alert::render(static::$errors[__FUNCTION__]["errExtension"] . $ext, "alert error");
				}
			}

			return true;
		}
		else {
			if ($this->error > 0) {
				Debug::err(new inputException(__METHOD__ . " err: " . $this->error));
				return Alert::render(static::codeToMessage($this->error), "alert error");
			}

			$ft = self::getFileType($this->name);
			if (!is_int($ft)) {
				Debug::err(new inputException(__METHOD__ . " extension: " . $ext));
				return Alert::render(static::$errors[__FUNCTION__]["errExtension"] . $ext, "alert error");
			}

			return true;
		}
	}

	/**
	 * Checks if a file is valid
	 * @param string $n
	 * @return string | int
	 */
	private static function getFileType($n)
	{
		$fi = self::fileInfo($n);
		if (!in_array(strtolower($fi["extension"]), array_values(static::$allowedExtensions))) {
			return strtolower($fi["extension"]);
		}

		return (int) array_search($fi["extension"], static::$allowedExtensions);
	}

	/**
	 * Are multiple files being uploaded?
	 * @return boolean
	 */
	private function isMultiple()
	{
		return is_array($this->tmp_name);
	}

	/**
	 * Returns file info
	 * @param string $n
	 * @return array
	 */
	private static function fileInfo($n)
	{
		$i = pathinfo($n);
		return array("filename" => $i["filename"], "extension" => $i["extension"]);
	}

	/**
	 * Handles single file upload
	 * @param string $on
	 * @param scalar $f
	 * @return boolean
	 */
	private function uploadFile($on, $f)
	{
		$p = $this->path;
		$n = $this->fileName;

		if (file_exists($p . "/" . $n)) {
			Debug::err(new appException("File $n already exists in $p!"));
			return Alert::render(static::$errors[__FUNCTION__]["fileExists"], "alert error");
		}

		if (move_uploaded_file($f, $p . "/" . $n)) {
			return static::$allowedExtensions[self::getFileType($on)];
		}
	}

	/**
	 * Handles multiple files upload
	 * @param array $n
	 * @param array $f
	 * @param array $s
	 * @return string
	 */
	private function uploadFiles(array $n, array $f, array $s)
	{
		if (count($f) > $this->maxFiles) {
			Debug::err(new appException("Trying to upload too many files"));
			return Alert::render(static::$errors[__FUNCTION__]["maxFiles"], "alert error");
		}
		elseif (count($f) > 1) {
			$zip = new Zip;
			$zipName = $this->fileName;

			if (file_exists($zipName)) {
				Debug::err(new appException("File $zipName already exists in " . $this->path . "!"));
				return Alert::render(static::$errors[__FUNCTION__]["fileExists"], "alert error");
			}

			$res = $zip->open($this->path . "/" . $zipName, Zip::CREATE);

			if ($res === true) {
				for ($i = 0; $i < count($f); $i++)
				{
					if (!$zip->addFile($f[$i], $n[$i])) {
						Debug::err(new appException("An unknown error ocurred with file " . $n[$i] . "!"));
						return Alert::render(static::$errors[__FUNCTION__]["unknown"], "alert error");
					}
				}
				$zip->close();
			}

			$ft = 3;
			$fs = filesize($this->path . "/" . $zipName);
		}
		else {
			$ft = $this->uploadFile($n[0], $f[0]);
			$fs = $s[0];

			if (!is_int($ft)) {
				Debug::err(new appException("An unknown error ocurred with file " . $n[$i] . "!"));
				return Alert::render(static::$errors[__FUNCTION__]["unknown"], "alert error");
			}
		}

		return array(static::$allowedExtensions[$ft], $fs, Alert::render(static::$errors[__FUNCTION__]["success"], "alert success"));
	}

	/**
	 * Executes upload
	 * @return string
	 */
	public function execute()
	{
		$ch = $this->checkFiles();

		if ($ch !== true) {
			return $ch;
		}

		if ($this->isMultiple()) {
			return $this->uploadFiles($this->name, $this->tmp_name, $this->size);
		}

		return $this->uploadFile($this->name, $this->tmp_name);
	}

	/**
	 * Returns an error message
	 * @param int $code
	 * @return string
	 */
	private static function codeToMessage($code)
	{
		switch ($code)
		{
			case UPLOAD_ERR_INI_SIZE:
				$message = "Ooops! The uploaded file exceeds the upload_max_filesize directive in php.ini.";
				break;
			case UPLOAD_ERR_FORM_SIZE:
				$message = "Ooops! The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
				break;
			case UPLOAD_ERR_PARTIAL:
				$message = "Ooops! The uploaded file was only partially uploaded.";
				break;
			case UPLOAD_ERR_NO_FILE:
				$message = "Ooops! No file was uploaded.";
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				$message = "Ooops! Missing a temporary folder.";
				break;
			case UPLOAD_ERR_CANT_WRITE:
				$message = "Ooops! Failed to write file to disk.";
				break;
			case UPLOAD_ERR_EXTENSION:
				$message = "Ooops! File upload stopped by extension.";
				break;

			default:
				$message = "Ooops! Unknown upload error.";
				break;
		}

		return $message;
	}

}
