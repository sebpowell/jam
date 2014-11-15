<?php

namespace Utilities;

class Image
{

	/**
	 * Generates image thumbnail
	 * @param object $s
	 * @param string $t
	 * @param int $w
	 * @param int $h
	 * @return boolean
	 */
	public static function generateImageThumbnail($s, $t, $w = 512, $h = 512)
	{
		if (!is_int($w) || !is_int($h)) {
			Debug::err(new inputException(__METHOD__));
			return false;
		}

		list($s_width, $s_height, $s_type) = getimagesize($s);

		switch ($s_type)
		{
			case IMAGETYPE_GIF:
				$s_gd_image = imagecreatefromgif($s);
				$ext = '.gif';
				break;
			case IMAGETYPE_JPEG:
				$s_gd_image = imagecreatefromjpeg($s);
				$ext = '.jpg';
				break;
			case IMAGETYPE_PNG:
				$s_gd_image = imagecreatefrompng($s);
				$ext = '.png';
				break;
			case IMAGETYPE_BMP:
				$s_gd_image = imagecreatefromgd($s);
				$ext = '.bmp';
				break;
		}

		if ($s_gd_image === false) {
			Debug::err(new appException("Could not create image"));
			return false;
		}

		$s_ratio_w = $s_width / $s_height;
		$s_ratio_h = $s_height / $s_width;

		if ($s_width < $s_height) {
			$t_width = $w;
			$t_height = floor(($s_ratio_h) * $h);
		}
		else {
			$t_height = $h;
			$t_width = floor(($s_ratio_w) * $w);
		}

		$t_gd_image = imagecreatetruecolor($t_width, $t_height);
		imagecopyresampled($t_gd_image, $s_gd_image, 0, 0, 0, 0, $t_width, $t_height, $s_width, $s_height);
		imagejpeg($t_gd_image, $t, 100);
		imagedestroy($s_gd_image);
		imagedestroy($t_gd_image);

		return true;
	}

	/**
	 * Generates thumbnails of various sizes
	 * @param object $f
	 * @param int $id
	 * @param array $s
	 * @return boolean
	 */
	public static function createThumbs($f, $id, $s = array(32, 512))
	{
		$fn = str_pad($id, 10, "0", STR_PAD_LEFT);

		foreach ($s as $k)
		{
			$a = UPLOAD_DIR . '/_avatars/size' . $k . '/' . $fn . '.jpg';

			if (self::generateImageThumbnail($f, $a, $k, $k) !== true) {
				Debug::err(new appException("Error creating thumbnail"));
				return false;
			}
		}

		return $fn . ".jpg";
	}

}
