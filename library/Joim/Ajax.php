<?php

namespace Joim;

/**
 * @desc AJAX handler
 * @author jmserrano
 * @since 2011-02-24
 * @modified 2014-10-13
 */
class Ajax {

	/**
	 * @desc Sends data in JSON format
	 * @param array $data
	 * @return void
	 */
	public static function json($data) {
		echo json_encode($data);
		die();
	}
}
