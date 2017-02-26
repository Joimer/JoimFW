<?php

namespace Filesystem;

interface IPath {

	public static function root() : string;

	public static function absolute(string $file) : string;
}
