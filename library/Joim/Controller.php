<?php

namespace Joim;

/**
 * @desc Main controller extended by all other controllers on the application. Has some main functions defined
 * @author jmserrano
 * @since 2012-02-03
 * @modified 2014-10-13
 */
class Controller {
	/**
	 * @desc Arguments for the controller
	 * @var array
	 */
	protected $args = [];

	/**
	 * @desc Name of the main template of the controller, if there's one
	 * @var string
	 */
	protected $template = '';

	/**
	 * @desc Template section to know what folder is it in
	 * @var string
	 */
	protected $templateSection = '';

	/**
	 * @desc Auth level required to access this controller. Can be overrided method by method.
	 * @var int
	 */
	protected $reqAuth = 0;

	/**
	 * @desc Whether this controller is accesed by Ajax or not
	 * @var bool
	 */
	protected $isAjax = false;

	/**
	 * @desc Instances of classes called
	 */
	protected static $_instance = null;
	
	/**
	 * @desc Class constructor. Passes args to the class.
	 * @param array $args Gets here from bootstrap
	 * @return void
	 */
	public function __construct($args=[], $template = 'index', $section = 'main') {
		$this->args = $args;
		$this->template = $template;
		$this->templateSection = $section;
		$this->_init();
	}

	/**
	 * @desc Function to call after construct is done on all controllers. No need to call parent::__construct() and repeat some of its code.
	 */
	protected function _init() {}

	/**
	 * @desc Late Static Binding singleton instancer.
	 */
	public static function getInstance() {
		if (!static::$_instance) static::$_instance = new static();
		return static::$_instance;
	}
	
	/**
	 * @desc Process a new action.
	 */
	 public function process($action) {
		$action = $action . 'Action';
		if (method_exists($this, $action)) {
			$this->$action();
		} else {
			throw new \Exception("Action {$action} does not exist in controller " . __CLASS__ . '.');
		}
	 }

	 /**
	  * @desc Returns controller's view
	  */
	public function view($name=false, $section=false) {
		static $views;
		if (!$views) $views = [];
		$name = ($name)? $name : $this->template;
		$section = ($section) ? $Section : $this->templateSection;
		if (!isset($views[$name . '|' . $section])) {
			$views[$name . '|' . $section] = new View($name, $section);
		}
		return $views[$name . '|' . $section];
	}

	/**
	 * @desc Take function arguments and adds them to page arguments
	 * @return void
	 */
	public function appendArgs() {
		foreach (func_get_args() as $arg) {
			$this->args[] = $arg;
		}
	}

	/**
	 * @desc Take function arguments and adds them to the beginning of the page arguments
	 * @return void
	 */
	public function prependArgs() {
		foreach (func_get_args() as $arg) {
			array_unshift($this->args, $arg);
		}
	}
	
	/**
	 * @desc Main method, index of the controller.
	 * @return void
	 */
	public function indexAction() {
		$this->view()->show();
	}

	/**
	 * @desc Method to check if a user is allowed
	 * @param int $authlevel Level of authority in the application
	 * @return bool
	 */
	protected function _isUserAllowed($authlevel) {
		return $authlevel <= intval(Session::get('auth'));
	}
}