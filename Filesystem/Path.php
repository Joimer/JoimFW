<?php

namespace Filesystem;

class Path implements IPath {

	public static function root() : string {
		return realpath(__DIR__ . DIRECTORY_SEPARATOR . '..');
	}

	public static function absolute(string $file) : string {
		return self::root() . DIRECTORY_SEPARATOR . $file;
	}
}
