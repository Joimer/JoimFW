<?php
/**
 * @desc Model for users. Most functions can be used by any type of application and are only examples, they will need DB support. This model uses Zend_Db adapter.
 * @author jmserrano
 * @since 2011-02-24
 */
class userModel {
	public static function userNameExists($name) {
		$select = dbHandler::getInstance()->select()
			->from('users', array('exists' => 'COUNT(username)'))
			->where('username = ?', $name)
			->query()
			->fetch();
		return (bool) $select['exists'];
	}
	
	public static function userMailExists($email) {
		$select = dbHandler::getInstance()->select()
			->from('users', array('exists' => 'COUNT(email)'))
			->where('email = ?', $email)
			->query()
			->fetch();
		return (bool) $select['exists'];
	}
	
	public static function userIdExists($id) {
		$select = dbHandler::getInstance()->select()
			->from('users', array('exists' => 'COUNT(id)'))
			->where('id = ?', $id)
			->query()
			->fetch();
		return (bool) $select['exists'];
	}

	public static function getHashPassById($id) {
		$select = dbHandler::getInstance()->select()
			->from('users', array('password' => 'SHA1(password)'))
			->where('id = ?', $id)
			->query()
			->fetch();
		return $select['password'];
	}
	
	public static function addUser($userData) {
		 dbHandler::getInstance()
			->insert('users', array(
				'username' => $userData['username'],
				'email' => $userData['email'],
				'password' => sha1(configHandler::get('salt') . sha1($userData['password']) . configHandler::get('salt')),
				'created' => time(),
				'auth' => 0
			));
		$select = dbHandler::getInstance()->select()
			->from('users', array('id'))
			->order('id DESC')
			->limit(1)
			->query()
			->fetch();
		dbHandler::getInstance()
			->insert('users_verification', array(
				'key' => $userData['key'],
				'user' => $select['id'],
				'sent' => time()
			));
	}

	public static function updateUser($userData) {
		if (count($userData) > 0) {
			dbHandler::getInstance()->update(
				'users',
				$userData,
				'id = ' . $userData['userid']
			);
		}
	}

	public static function checkKey($key) {
		$query = dbHandler::getInstance()->select()
			->from('users_verification', array('user'))
			->where('`key` = ?', $key)
			->where('used = 0')
			->query()
			->fetch();
		return (isset($query['user']))? $query : false;
	}

	public static function activateUser($id, $key) {
		try {
			dbHandler::getInstance()->update(
				'users_verification',
				array('used' => 1),
				"`key` = '{$key}'"
			);
			dbHandler::getInstance()->update(
				'users',
				array('auth' => 1),
				'id = '. $id
			);
		} catch (Exception $e) {
			return false;
		}
	}

	public static function login($username, $password) {
		$select = dbHandler::getInstance()->select()
			->from('users', array('id'))
			->where('username = ?', $username)
			->where('password = ?', $password)
			->where("auth > 0")
			->query()
			->fetch();
		return (isset($select['id']))? $select['id'] : false;
	}

	public static function loginByHashPass($username, $password) {
		$select = dbHandler::getInstance()->select()
			->from('users', array('id'))
			->where('username = ?', $username)
			->where('SHA1(password) = ?', $password)
			->where("auth > 0")
			->query()
			->fetch();
		return (isset($select['id']))? $select['id'] : false;
	}
	
	public static function getAllUserData($id) {
		return dbHandler::getInstance()->select()
			->from('users')
			->where('id = ?', $id)
			->query()
			->fetch();
	}
	
	public static function updateLastLogin($keyId) {
		dbHandler::getInstance()->update(
			'users',
			array('last_login' => time()),
			'id = '. $keyId
		);
	}
	
	public static function getNameById($id) {
		$select = dbHandler::getInstance()->select()
			->from('users', array('username'))
			->where('id = ?', $id);
		$select = $select->query();
		$select = $select->fetch();
		return $select['username'];
	}

	public static function getIdByName($name) {
		$name = strtolower($name);
		$select = dbHandler::getInstance()->select()
			->from('users', array('id'))
			->where('LOWER(username) = ?', $name)
			->query()
			->fetch();
		return $select['id'];
	}
}
?>