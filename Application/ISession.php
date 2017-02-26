<?php

namespace Application;

interface ISession {

	public function start();

	public function end();
	
	public function set(string $name, $value);
	
	public function get(string $name);
}
