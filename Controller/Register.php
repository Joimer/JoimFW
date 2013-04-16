<?php

namespace Controller;


/**
 * @desc Controller to register new accounts
 * @author jmserrano
 * @since 2013-05-05
 */
class Register extends \Joim\Controller {

	public function _init() {
		$this->template = 'register';
		$this->templateSection = 'public';
	}
	/**
	 * @desc Shows a registry form
	 * @return void
	 */
	public function indexAction() {
		$this->view()->show();
	}
}
