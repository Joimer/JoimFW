<?php

namespace Joim;

/**
 * @desc Handles the application session
 * @author jmserrano
 * @since 2011-03-03
 * @modified 2014-10-13
 */
class Session {
	
	/**
	 * @desc Session namespace
	 * @var string
	 */
	private static $namespace;
	const EXPIRETIME = 86400;
	
	/**
	 * @desc Constructor
	 * @return void
	 */
	protected static function _init() {
		self::$namespace = sha1($_SERVER['SERVER_ADDR'] . Config::get('salt'));
		self::set('expires', time() + self::EXPIRETIME);
	}
	
	public static function start() {
		session_start();
		self::_init();
		$expires = self::get('expires');
		if (!empty($expires) && $expires < time()) {
			session_unset();
			session_destroy();
			session_start();
			session_regenerate_id(true);
			self::$namespace = sha1($_SERVER['SERVER_ADDR'] . Config::get('salt'));
			self::set('expires', time() + self::EXPIRETIME);
		} else {
			$started = self::get('started');
			if (!empty($started)) {
				if (time() - $started > 43200) session_regenerate_id();
			} else {
				self::set('started', time());
			}
		}
	}
	
	/**
	 * @desc Utterly and ultimately destroy the session variables
	 * Is this really needed in 2014 and in 5.5=<?
	 */
	public static function end() {
		session_unset();
		session_destroy();
		$_SESSION = array();
		unset($_SESSION);
	}
	
	public static function set($name, $value) {
		return $_SESSION[self::$namespace][$name] = $value;
	}
	
	public static function get($name) {
		if (isset($_SESSION[self::$namespace][$name])) {
			return $_SESSION[self::$namespace][$name];
		} else {
			return false;
		}
	}
	
	public static function logIn($userid) {
		self::set('loggedin', true);
		self::set('expires', time() + self::EXPIRETIME);
		self::set('userid', $userid);
		self::set('started', time());
		// Get user data
		$userData = User_Model::getAllUserData($userid);
		self::set('username', $userData['username']);
		self::set('auth', $userData['auth']);
	}

	public static function reloadSessionData($userid=0) {
		if ($userid === 0) $userid = (int) self::get('userid');
		if ($userid > 0) {
			$userData = User_Model::getAllUserData($userid);
			self::set('loggedin', true);
			self::set('expires', time() + self::EXPIRETIME);
			self::set('userid', $userid);
			self::set('started', time());
			self::set('username', $userData['username']);
			self::set('auth', $userData['auth']);
		}
	}
	
	public static function isLoggedIn() {
		return self::get('loggedin');
	}

	public static function getCurrentNamespace() {
		return (isset(self::$namespace))? self::$namespace : null;
	}
}
