<?php

namespace Joim;

/**
 * @desc Autoload function, loads automatically classes called by the application
 * @author jmserrrano
 * @since 2013-04-20
 * @modified 2014-10-13
 * @TODO Register new class name loaders outside of framework to keep framework totally separated from application
 */
class Load {

	/**
	 * @desc Function that registers this as the autoloader
	 */
	public static function register() {
		spl_autoload_register(['Joim\Load', 'loader']);
	}

	/**
	 * @desc Function that tries to load the file for the required class
	 */
	 public static function loader($className) {
	 	static $calls;
	 	if (!is_array($calls)) $calls = [];
	 	if (!isset($calls[$className])) {
	 		$fullRoute = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
	 		// If it's not a file of the actual app, it's a library file.
	 		if (!file_exists($fullRoute)) {
	 			$fullRoute = 'library' . DIRECTORY_SEPARATOR . $fullRoute;
	 		}
			if (file_exists($fullRoute)) {
				require_once($fullRoute);
				// @TODO: More information saved for Debugging
				$calls[$className] = [
					'called' => microtime(),
					'route' => $fullRoute
				];
			} else {
				// @TODO: Pass this through Framework with a cute 404 error or something.
				header('HTTP/1.0 404 Not Found');
				echo 'File does not exist (Tried: ' . $fullRoute . ')!<br /><pre>';
				debug_print_backtrace();
				die();
			}
	 	}
	 }
}