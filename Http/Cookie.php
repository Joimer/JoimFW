<?php

namespace Http;

class Cookie {

	public static function set() {
		$agent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : 'undefined';
		$usercookie = sha1($agent . $_SERVER['REMOTE_ADDR']);
		setcookie('application', $usercookie, time() + 31536000);

		return $usercookie;
	}

	public static function get() {
		return $_COOKIE['application'];
	}
}
