<?php

namespace Application\Config;

use \Serialization\IReader;

interface IConfig {

	public function load(string $file, IReader $reader);

	public function get(string $key) : string;
}
