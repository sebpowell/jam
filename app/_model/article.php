<?php

namespace Model;

use Utilities\Http;
use Utilities\Debug;
use Utilities\Parsedown;
use Utilities\appException;

class Article
{

	/**
	 * Gets data points from a given directory
	 * @param string $dir
	 * @return array
	 */
	public static function getContentDataFrom($dir) {
		$contentsDir = CONTENT_DIR . "/" . $dir;

		// This gets all files from the contents directory into an array.
		$f = glob($contentsDir . "/*", GLOB_NOSORT);

		// This array will be populated with all the file data, except those
		// whose visibility has been set to false.
		$fD = array();

		// This loop goes through every file, looks for predefined tags (see
		// further below), parses it, and populates the file data array.
		foreach ($f as $file) {

			// This is an array, which will be populated with data from the
			// current file in the loop.
			$fDc = array();

			// This gets the contents of the current file.
			$fC = file_get_contents($file);

			// These are the predefined required tags, which every file shall
			// contain. If it does not, an error is thrown.
			$fT = array(
					"title", "desc", "date", "visible", "category", "author"
				);

			// For each of the above tags, this gets the data from a specific
			// tag. If that tag has not been found within current file, the
			// value is an empty string.
			foreach ($fT as $tag) {
				if (preg_match_all('/\{' . $tag . '(.*?)\/' . $tag . '}/', $fC, $m)) {
					$fDc[$tag] = trim($m[1][0]);
				}
			}

			// This gets the file name from the current file path.
			$fileName = basename($file, ".md");

			// This ensures that all of the above is assigned only if the file's
			// visibility has not been set to false.
			if (!isset($fDc["visible"]) || $fDc["visible"] !== "false") {

				// $fD is the File Data array, which is a compilation of all
				// file data from within given directory.
				$fD[$fileName] = $fDc;
			}
		}

		// Array keys are the actual urls, which ensures that only existing and
		// valid files will be callable; Array values are the actual accumulated
		// data form within a dir.
		return $fD;
	}

	/**
	 * Parses markdown (.md) and returns html
	 * @param string $folder
	 * @param string $filename
	 * @return string
	 */
	public static function getContentsOf($folder, $filename) {
		$parser = new Parsedown();
		return $parser->text(
			file_get_contents( CONTENT_DIR . "/" . $folder . "/" . $filename . ".md" )
		);
	}

}
