<?php
/**
 * @desc DB Handler. Returns a Zend Db instance
 * @author jmserrano
 * @since 2011-02-24
 */
class dbHandler {
	/**
	 * @desc Returns a Zend_Db instance. Feel free to use any adapter of choice.
	 * @return object Zend_Db
	 */
	public static function getInstance() {
		static $adapter = null;
		if (empty($adapter)) {
			$adapter = Zend_Db::factory('Mysqli', array(
				'host'     => configHandler::get('dbhost'),
				'username' => configHandler::get('dbuser'),
				'password' => configHandler::get('dbpass'),
				'dbname'   => configHandler::get('dbname'),
				'driver_options' => array(MYSQLI_INIT_COMMAND => 'SET NAMES UTF8;')
			));
		}

		return $adapter;
	}
}
?>
