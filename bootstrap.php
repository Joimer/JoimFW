<?php
/**
 * @desc JoimFW's Bootstrap
 * @author jmserrano
 * @since 2011-02-24
 * @version 1.3
 */
class JoimFW {
	/**
	 * @desc Loads website configuration
	 * @return void
	 */
	public static function config() {
		$route = $_SERVER['DOCUMENT_ROOT'];
		if (!defined('DOC_ROOT')) define('DOC_ROOT', $route);
		ini_set('include_path', ini_get('include_path') . ";{$route};{$route}/Zend/;{$route}/controllers/;{$route}/models/;{$route}/handlers/;{$route}/config/");
		set_error_handler("JoimFW::errorHandler");
		error_reporting(E_ALL ^ E_NOTICE);
		date_default_timezone_set('Europe/Madrid');
	}
	
	/**
	 * @desc Takes the query string and checks what controller and action to use
	 * @return array $pageVars
	 */
	public static function getVars($aliases) {
		// We get the query string
		$actions = (!empty($_GET['actions']))? (string)strip_tags(trim($_GET['actions'])) : 'home/index';
		if (!stripos($actions, '/')) $actions .= '/index';
		$actions = explode('/', $actions);
		
		// Now we get what we gotta do
		$controller = strtolower(array_shift($actions));
		$action = array_shift($actions);
		
		// Check for controller and/or actions aliases (so we can have different URIs for dif. langs)
		if (array_key_exists($controller, $aliases)) {
			$controller = $aliases[$controller];
		}
		if (array_key_exists($action, $aliases)) {
			$action = $aliases[$action];
		}
		
		// Now we are left with either an empty array or the page vars
		$pageVars = array('controller' => $controller, 'action' => $action);
		if (count($actions) > 0) {
			// We just pass the actions to the vars.
			foreach ($actions as $key=>$var) {
				$pageVars[] = $var;
			}
		}
		return array_merge($pageVars, $_POST);
	}
	
	/**
	 * @desc Loads a page
	 * @param array $pageVars
	 * @return void
	 */
	public static function load($pageVars) {
		if (class_exists("{$pageVars['controller']}Controller")) {
			eval("\$controller = new {$pageVars['controller']}Controller(\$pageVars);");
			if (method_exists($pageVars['controller'] . 'Controller', $pageVars['action'])) {
				$controller->$pageVars['action']();
			} else {
				$controller->prependArgs($pageVars['action']);
				$controller->index();
			}
		} else {
			$controller = new errorController($pageVars);
			$controller->e404();
		}
	}
	
	/**
	 * @desc Handles an error
	 * @param object $e Exception | ErrorException
	 * @return void 
	 */
	public static function execError($e) {
		$controller = new errorController();
		$errortext = date('[Y-m-d H:i:s] ')
		. "\nError: " . $e->getMessage() . "\n"
		. 'En: ' . $e->getFile() . ':' . $e->getLine() . "\n"
		. "Traza:\n" . $e->getTraceAsString() . "\n"
		. "-------------------\n\n";
		logHandler::log($errortext);
		mailHandler::mail(
			'SysAdmin <admin@example.com>',
			date('[H:i:s d-m-Y] ') . 'Error report: Error in application',
			"There has been an error on application.\nThe error is:\n------------------\n"
			. $errortext
		);
		$controller->error(500);
	}
	
	/**
	 * @desc Error handler for the application.
	 * @param int $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param int $errline
	 * @return void
	 */
	public static function errorHandler($errno, $errstr, $errfile, $errline) {
		self::execError(
			new ErrorException($errstr . "\n" . debug_backtrace(), 0, $errno, $errfile, $errline)
		);
	}
}
?>
