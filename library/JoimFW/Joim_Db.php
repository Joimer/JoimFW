<?php
/**
 * @desc Main DB handler. Encapsulates Zend_Db
 * @author jmserrano
 * @since 2011-02-24
 * @modified 2013-06-29
 */
class Joim_Db extends Zend_Db {

	/**
	 * @desc Returns a Zend_Db instance. Feel free to use any adapter of choice.
	 * @return object Zend_Db
	 */
	public static function getInstance() {
		static $adapter = null;
		if (empty($adapter)) {
			$adapter = self::factory('Mysqli', array(
				'host'     => Joim_Config::get('database.host'),
				'username' => Joim_Config::get('database.user'),
				'password' => Joim_Config::get('database.password'),
				'dbname'   => Joim_Config::get('database.name'),
				'driver_options' => array(MYSQLI_INIT_COMMAND => 'SET NAMES UTF8;')
			));
		}

		return $adapter;
	}
}