<?php

namespace Joim;

/**
 * @desc This class serves as application bootstrap, initialising what's necessary to run it.
 * Previously main JoimFW class.
 * @author jmserrano
 * @since 2011-02-24
 * @modified 2014-10-13
 */
class Bootstrap {

	/**
	 * @desc This function is called upon application start up and it runs all the necessary methods.
	 * @return void
	 * @throws Exception
	 */
	public static function init() {
		Session::start();
		self::config();
		self::load();
	}
	/**
	 * @desc Loads website configuration
	 * @return void
	 */
	public static function config() {
		set_error_handler("\Joim\Error::errorHandler");
		date_default_timezone_set('Europe/Madrid');
		Config::loadConfig();
		// @TODO: Automatic time zone detection
	}
	
	/**
	 * @desc Takes the query string and returns the data for the page to load
	 * @return array $pageVars
	 */
	public static function getVars() {
		$aliases = false; // @TODO: Class aliases
		// We get the query string
		$actions = (!empty($_GET['actions']))? (string)strip_tags(trim($_GET['actions'])) : 'index/index';
		if (!stripos($actions, '/')) $actions .= '/index';
		$actions = explode('/', $actions);
		
		// Get the controller from the first parameter and the main action from the second
		$controller = strtolower(array_shift($actions));
		$action = array_shift($actions);
		
		// Now we are left with either an empty array or the page vars
		$pageVars = ['controller' => $controller, 'action' => $action];
		if (count($actions) > 0) {
			// We just pass the actions to the vars.
			foreach ($actions as $var) {
				$pageVars[] = $var; // @TODO: Proper sanitisation, when necessary.
			}
		}

		// We return both the post data and page vars, which will be passed to 
		// controller by construct and held there for usage by the methods.
		return array_merge($pageVars, $_REQUEST);
	}
	
	/**
	 * @desc Loads the requested page
	 * @param array $pageVars
	 * @return void
	 */
	public static function load() {
		$pageVars = self::getVars();
		if (in_array($pageVars['controller'], ['index', 'public', 'news'])) {
			$controller = new \Controller\Home($pageVars);
			$controller->process('index');
		} else {
			$controllerName = '\\Controller\\' . ucfirst(strtolower($pageVars['controller']));
			$controller = new $controllerName($pageVars);
			$controller->process($pageVars['action']);
		}
	}
}
