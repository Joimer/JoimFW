<?php
/**
 * @desc Handles the application session
 * @author jmserrano
 * @since 2011-03-03
 */
class sessionHandler {
	
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
	public function __construct() {
		$agent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : 'undefined';
		self::$namespace = sha1($_SERVER['SERVER_ADDR'] . $agent);
		self::set('expires', time() + 86400);
	}
	
	public function start() {
		session_start();
		$expires = self::get('expires');
		if (!empty($expires) && $expires < time()) {
			session_unset();
			session_destroy();
			session_start();
			session_regenerate_id(true);
			$agent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : 'undefined';
			self::$namespace = sha1($_SERVER['SERVER_ADDR'] . $agent);
			self::set('expires', time() + self::EXPIRETIME);
		} else {
			$started = $this->get('started');
			if (!empty($started)) {
				if (time() - $started > 43200) {
					session_regenerate_id();
				}
			} else {
				self::set('started', time());
			}
		}
	}
	
	public function end() {
		session_unset();
		session_destroy();
		$_SESSION = array();
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
	
	public function logIn($userid) {
		self::set('loggedin', true);
		self::set('expires', time() + self::EXPIRETIME);
		self::set('userid', $userid);
		self::set('started', time());
		// Get user data
		$userData = userModel::getAllUserData($userid);
		self::set('username', $userData['username']);
		self::set('auth', $userData['auth']);
	}

	public static function reloadSessionData($userid=0) {
		if ($userid == 0) $userid = (int) self::get('userid');
		if ($userid > 0) {
			$userData = userModel::getAllUserData($userid);
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
