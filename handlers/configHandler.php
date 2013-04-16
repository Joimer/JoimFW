<?php
/**
 * @desc Configuration Handler, used to save configuration settings you might need on other places of the app
 * @author jmserrano
 * @since 2011-02-24
 */
class configHandler {
	/**
	 * @desc Class constructor
	 * @return void
	 */
	public function __construct() {
	}
	
	/**
	 * @desc Gets a pre-set configuration variable
	 * @return mixed
	 */
	public static function get($value, $valueKey=NULL) {
		$configValues = array(
			'dbhost' => 'your.host.com',
			'dbuser' => 'user',
			'dbpass' => 'password',
			'dbname' => 'database_name',
			'aliases' => array(),
			'salt' => 'thisIsADbSalt',
			'authNames' => array(
				'0' => 'Guest',
				'1' => 'User',
				'2' => 'Moderator',
				'3' => 'Administrator'
			)
		);
		if ($valueKey === NULL) {
			return $configValues[$value];
		} else {
			return $configValues[$value][$valueKey];
		}
	}
}
?>
