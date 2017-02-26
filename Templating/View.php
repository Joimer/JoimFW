<?php

namespace Templating;

use \Filesystem\File;
use \Filesystem\Path;
use \Serialization\IStringable;

class View implements IStringable {

	protected $contents = '';

	public function __construct(string $dir) {
		$route = Path::absolute('templates') . DIRECTORY_SEPARATOR . $dir . '.phtml';
		if (File::exists($route)) {
			$this->contents = File::get($route);
		}
	}

	public function show() : string {
		return $this->contents;
	}

	public function parse(string $name, string $content) {
		$this->contents = str_replace("{{$name}}", $content, $this->contents);
	}

	public function __toString() : string {
		return $this->show();
	}
}
