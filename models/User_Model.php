<?php
/**
 * @desc Model for users.
 * @author jmserrano
 * @since 2011-02-24
 */
class User_Model extends Joim_Model {
	
	/**
	 * @desc Example function
	 */
	public static function userAccountExists($username) {
		$select = Joim_Db::getInstance()->select()
			->from('accounts', array('exists' => 'COUNT(username)'))
			->where('username = ?', $username)
			->query()
			->fetch();
		return (bool) $select['exists'];
	}
}
