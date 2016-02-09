<?php

namespace Joim;

/**
 * @desc Configuration File, used to save configuration settings you might need on other places of the app
 * @author jmserrano
 * @since 2011-02-24
 * @modified 2014-10-13
 * @modified 2016-02-09
 * @TODO Still to do and use.
 */
class Config {
	const INIFILE = 'config' . DIRECTORY_SEPARATOR . 'config.ini';
	private static $configValues = [];

	/**
	 * @desc Class constructor
	 * @return void
	 */
	public function __construct() {
		$this->loadConfig();
	}

	/**
	 * @desc Loads the configuration file that can be found in /config/config.ini
	 * @return void
	 */
	public static function loadConfig() {
		self::$configValues = parse_ini_file(self::INIFILE);
	}
	
	/**
	 * @desc Gets a pre-set configuration variable
	 * @return mixed
	 */
	public static function get($value) {
		return (isset(self::$configValues[$value]))? self::$configValues[$value] : false;
	}
}
