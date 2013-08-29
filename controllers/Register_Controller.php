<?php
/**
 * @desc Controller to register new MK3 accounts
 * @author jmserrano
 * @since 2013-05-05
 */
class Register_Controller extends Joim_Controller {

	public function __construct() {
		$this->template = 'register';
		$this->template_section = 'public';
	}
	/**
	 * @desc Shows a registry form
	 * @return void
	 */
	public function index() {
		$this->view()->show($this->args);
	}
}
