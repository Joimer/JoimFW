<?php

namespace Joim;

/**
 * @desc Translation class. This class takes a text ID and gets the correct value for a language
 * @author jmserrano
 * @since 2013-06-18
 * @modified 2014-10-13
 */
class Texts {
	const DEF = 'es';
	/**
	 * @desc Class constructor
	 * @return void
	 */
	public function __construct() {}
	
	/**
	 * @desc Gets a pre-set configuration variable
	 * @return mixed
	 */
	public static function get($id, $lang=false) {
		if (!$lang) $lang = self::lang();
		return \Model\Texts::get($id, $lang);
	}
	
	public static function lang() {
		$lang = Session::get('lang');
		//if (!$lang) $lang = Language::getLang();
		if (!$lang) $lang = self::DEF;
		
		return $lang;
	}
}