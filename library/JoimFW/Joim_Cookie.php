<?php
/**
 * @desc Cookie Handler
 * @author jmserrano
 * @since 2012-02-10
 */
class Joim_Cookie {
	/**
	 * @desc Sets user cookie
	 * @return string $usercookie
	 */
	public static function setUserCookie() {
		$agent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : 'undefined';
		$usercookie = sha1($agent . 'digest' . $_SERVER['REMOTE_ADDR']);
		setcookie('application', $usercookie, time() + 31536000);
		
		return $usercookie;
	}

	/**
	 * @desc Gets user cookie from navigator
	 * @return string
	 */
	public static function getUserCookie() {
		if (!isset($_COOKIE['application'])) {
			$_COOKIE['application'] = self::setUserCookie();
		}

		return $_COOKIE['application'];
	}
	
	/**
	 * @desc Sets a cookie to remember the user.
	 * @param int $id
	 * @param string $password
	 * @return string
	 */
	public static function setRememberCookie($id=0, $password) {
		if ($id > 0) {
			setcookie('memrem', $id.'#'.sha1($password), time() + 31536000);
			return $id.'-'.$password;
		}
	}

	/**
	 * @desc Gets the remember user cookie
	 * @return void
	 */
	public static function getRememberCookie() {
		return (isset($_COOKIE['memrem'])) ? $_COOKIE['memrem'] : false;
	}

	/**
	 * @desc Logs in a user by a set cookie
	 * @return void
	 */
	public static function logInUserByCookie() {
		$cookie = self::getRememberCookie();
		if ($cookie) {
			$data = explode('#', $cookie);
			$try = userModel::loginByHashedPass(userModel::getNameById($data[0]), $data[1]);
			if ($try !== false) {
				$session = new sessionHandler();
				$session->logIn($try);
				userModel::updateLastLogin($try);
			}
		}
	}
}