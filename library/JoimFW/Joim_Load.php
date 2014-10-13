<?php
/**
 * @desc Autoload function, loads automatically classes called by the application
 * @author jmserrrano
 * @since 2013-04-20
 * @modified 2013-06-29
 * @TODO Use of spl_autoload_register
 * @TODO Register new class name loaders outside of framework to keep framework totally separated from application
 */
function __autoload($className) {
	JoimFW::loader($className);
}

class Joim_Load {

	/**
	 * @desc Function that registers this as the autoloader
	 */
	public static function register() {
		spl_autoload_register(array('Joim_Load', 'loader'));
	}

	/**
	 * @desc Function that tries to load the file for the required class
	 */
	 public static function loader($className) {
	 	static $calls;
	 	if (!is_array($calls)) $calls = array();
	 	if (!isset($calls[$className])) {
	 		$fullRoute = '';
	 		switch ($className) {
				// Joim Framework classes
				case (substr($className, 0, 5) === 'Joim_'):
					$fullRoute = "library/JoimFW/{$className}.php";
					break;
				// Zend Framework classes used for this application
				case (stripos($className, 'Zend') !== false):
					$fullRoute = 'library/' . str_replace('_', '/', $className) . ".php";
					break;
				// Application controllers
				case (stripos($className, 'controller') !== false):
					$fullRoute = "controllers/{$className}.php";
					if (!file_exists($fullRoute)) {
						$controller = new Error_Controller();
						$controller->process('error', 404);
					}
					break;
				// Application models
				case (stripos($className, 'model') !== false):
					$fullRoute = "models/{$className}.php";
					break;
				// Application crons
				case (stripos($className, 'cron') !== false):
					$fullRoute = "crons/{$className}.php";
					break;
			}
			if (file_exists($fullRoute)) {
				require_once($fullRoute);
				// @TODO: More information saved for Debugging
				$calls[$className] = array(
					'called' => microtime(),
					'route' => $fullRoute
				);
			} else {
				print_r('File "' . $fullRoute . '" does not exist!');
				debug_print_backtrace();
				die();
			}
	 	}
	 }
}