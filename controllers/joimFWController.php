<?php
/**
 * @desc Main controller extended by all other controllers on the application. Has some main functions defined
 * @author jmserrano
 * @since 2012-02-03
 */
class joimFWController {
	/**
	 * @desc Arguments for the controller
	 * @var array
	 */
	protected $args = array();
	/**
	 * @desc Name of the main template of the controller, if there's one
	 */
	protected $main_template = '';
	protected $template_section = '';
	/**
	 * @desc Auth level required to access this controller. Can be overrided method by method.
	 */
	protected $req_auth = 0;
	
	/**
	 * @desc Class constructor. Passes args to the class
	 * @param array $args Gets here from bootstrap
	 * @return void
	 */
	public function __construct($args=array()) {
		$this->args = $args;
	}

	/**
	 * @desc Take function arguments and adds them to page arguments
	 */
	public function appendArgs() {
		$args = func_get_args();
		foreach ($args as $arg) {
			$this->args[] = $arg;
		}
	}

	/**
	 * @desc  Take function arguments and adds them to page arguments
	 */
	public function prependArgs() {
		$args = func_get_args();
		foreach ($args as $arg) {
			array_unshift($this->args, $arg);
		}
	}
	
	/**
	 * @desc Main method, index of the controller.
	 * @return void
	 */
	public function index() {
		$view = (strlen($this->template_section) > 0)? new htmlHandler($this->main_template, $this->template_section) : new htmlHandler($this->main_template);
		$view->show($this->args);
	}

	/**
	 * @desc Method to check if a user is allowed
	 * @param int $authlevel
	 * @return bool
	 */
	protected function _isUserAllowed($authlevel) {
		return $authlevel <= intval(sessionHandler::get('auth'));
	}
}
?>
