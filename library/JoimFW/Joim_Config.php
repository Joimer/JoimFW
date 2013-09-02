<?php
/**
 * @desc Configuration File, used to save configuration settings you might need on other places of the app
 * @author jmserrano
 * @since 2011-02-24
 */
class Joim_Config {
	const INIFILE = 'config/config.ini';
	private static $configValues = array();

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