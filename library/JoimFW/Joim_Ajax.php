<?php
/**
 * @desc AJAX handler
 * @author jmserrano
 * @since 2011-02-24
 * @modified 2013-06-29
 */
class Joim_Ajax {
	
	/**
	 * @desc Class constructor
	 * @return void
	 */
	public function __construct() {
	}
	
	/**
	 * @desc Sends data in JSON format
	 * @param array $data
	 * @return void
	 */
	public static function json($data) {
		echo json_encode($data);
	}

	/**
	 * @desc Sends raw data
	 * @param string $data
	 * @return void
	 */
	public static function pure($data) {
		echo $data;
	}
}