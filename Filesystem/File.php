<?php

namespace Filesystem;

class File implements IFile {
	public static function exists(string $dir) : bool {
		return file_exists($dir);
	}

	public static function get(string $dir) : string {
		return file_get_contents($dir) ?? '';
	}
}
