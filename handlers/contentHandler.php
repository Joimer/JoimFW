<?php
/**
 * @desc Handler to control content input by users
 * @author jmserrano
 * @since 2012-02-23
 */
class contentHandler {
	/**
	 * @desc Checks for ortography in a text and fixes it (spanish example)
	 * @param string $string
	 * @return string $falta
	 */
	public static function draeFriend($string) {
		$falta = false;
		$sangrado_ocular = array(
			'havia', 'havía', 'abía', 'avia', 'avía', // Mortales enemigos de "había" (abia es un arándano)
			'a ber', 'ha ver', 'aver', 'haver', // Detractores del "haber / a ver"
			'ací', 'aci', 'cojía', 'cojia', 'coji', 'cojí', 'desir', 'dise', 'deceo', // Quimeras varias, en su mayoría latinas
			// y más...
			'estubo', 'garage', 'ivamos', 'tanbien', 'veniste', 'freído', 'freido'
		);
		foreach ($sangrado_ocular as $crimen) {
			if (stripos($string, $crimen . ' ') || stripos($string, ' ' . $crimen) || stripos($string, ' ' . $crimen . ' ')) {
				$falta = $crimen;
				break;
			}
		}
		return $falta;
	}

	/**
	 * @desc Filters content types
	 * @param string $string
	 * @param string $type
	 * @return bool $valid
	 */
	public static function valid($string, $type) {
		$valid = true;
		if (empty($string)) $valid = false;
		else {
			switch ($type) {
				case 'alnum':
					$valid = !preg_match('/[^A-z0-9]/', $string);
					break;
				case 'mail':
					// This is not a perfect mail filter
					$valid = filter_var($string, FILTER_VALIDATE_EMAIL);
			}
		}

		return $valid;
	}

	/**
	 * @desc Cleans an array or string
	 * @return void
	 */
	public static function cleanse(&$data) {
		if (is_string($data)) {
			$data = strip_tags(trim($data));
		}
		if (is_array($data)) {
			$temp = array();
			foreach ($data as $key=>$value) {
				self::cleanse($value);
				$temp[$key] = $value;
			}
			$data = $temp;
		}
	}

	/**
	 * @desc Checks if a file is allowed to be uploaded by type
	 * @param array $file Data of the uploaded file
	 * @return void
	 */
	public static function allowedFile($file, &$type) {
		$allowed = array(
			IMAGETYPE_GIF,
			IMAGETYPE_JPEG,
			IMAGETYPE_PNG
		);
		$exif_imagetype = exif_imagetype($file['tmp_name']);
		$type = image_type_to_mime_type($exif_imagetype);
				
		return (in_array($exif_imagetype, $allowed)) && ($type == $file['type']);
	}
}
