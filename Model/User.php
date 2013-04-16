<?php

namespace Model;

/**
 * @desc Model for users.
 * @author jmserrano
 * @since 2011-02-24
 */
class User extends \Joim\Model {
	
	/**
	 * @desc Example function
	 */
	public static function userAccountExists($username) {
		/*TODO
		$select = Joim\Db::getInstance()->select()
			->from('accounts', array('exists' => 'COUNT(username)'))
			->where('username = ?', $username)
			->query()
			->fetch();
		return (bool) $select['exists'];*/
		return false;
	}
}
