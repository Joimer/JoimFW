<?php

namespace Application;

class Crypt {

	public static function hashPassword($password) {
		return password_hash($password, PASSWORD_BCRYPT);
	}

	public static function passwordVerify($password, $hash) {
		return password_verify($password, $hash);
	}
}
