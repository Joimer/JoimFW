<?php

namespace Application;

use Application\Config\IConfig;

class Session implements ISession {

	private $expireTime;

	public function __construct(IConfig $config) {
		$this->expireTime = (int) ($config->get('session-expiration-time') ?? 86400);
		$this->start();
	}

	public function __destruct() {
		$this->end();
	}

	public function start() {
		session_start();
		$this->set('started', time());
	}

	public function end() {
		session_unset();
		session_destroy();
	}
	
	public function set(string $name, $value) {
		return $_SESSION[$name] = $value;
	}
	
	public function get(string $name) {
		$value = null;
		if (isset($_SESSION[$name])) {
			$value = $_SESSION[$name];
		}

		return $value;
	}
}
