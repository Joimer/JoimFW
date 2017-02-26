<?php

namespace Filesystem;

interface IFile {
	public static function exists(string $dir);

	public static function get(string $dir);
}
