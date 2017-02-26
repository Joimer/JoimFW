<?php

namespace Application\Config;

use Filesystem\File;
use Filesystem\Path;
use Serialization\IReader;

class Config implements IConfig {

	protected $values;

	public function __construct(string $file, IReader $reader) {
		$this->load($file, $reader);
	}

	public function load(string $file, IReader $reader) {
		$route = Path::absolute($file);
		if (File::exists($route)) {
			$contents = File::get($route);
			$this->values = $reader->read($contents);
		}
	}

	public function get(string $key) : string {
		return $this->values[$key] ?? '';
	}
}
