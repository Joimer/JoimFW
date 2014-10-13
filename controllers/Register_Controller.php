<?php
/**
 * @desc Controller to register new accounts
 * @author jmserrano
 * @since 2013-05-05
 */
class Register_Controller extends Joim_Controller {

	public function _init() {
		$this->template = 'register';
		$this->template_section = 'public';
	}
	/**
	 * @desc Shows a registry form
	 * @return void
	 */
	public function indexAction() {
		$this->view()->show();
	}
}
