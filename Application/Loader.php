<?php

namespace Application;

class Loader implements ILoader {

	public static function load(string $className) {
 		$fullRoute = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
		if (file_exists($fullRoute)) {
			require_once($fullRoute);
		} else {
			// @TODO: Remove.
			// For debugging purposes.
			header('HTTP/1.0 404 Not Found');
			echo 'File does not exist (Tried: ' . $fullRoute . ')!<br /><pre>';
			debug_print_backtrace();
			die();
		}
	}
}
