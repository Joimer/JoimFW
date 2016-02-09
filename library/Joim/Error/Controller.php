<?php

namespace Joim\Error;

/**
 * @desc Error controller for the Framework
 * @author jmserrano
 * @since 2011-02-24
 * @modified 2013-06-29
 */
class Controller extends \Joim\Controller {

	/**
	 * @desc Shows generic error
	 * @return void
	 */
	public function index() {
		$this->view = new htmlHandler('error', 'errors');
		$this->show($this->args);
	}

	/**
	 * @desc Shows a specific error given a valid error number
	 * @param int $errno
	 */
	public function error($errno) {
		header('Status: ' . Joim_Error::getErrHeader($errno));
		die(debug_backtrace());
		$view = new htmlHandler('error_to_user', 'errors');
		$view->addData(array(
			'code' => $errno,
			'message' => Joim_Error::getErrorMsg($errno),
			'debug' => debug_backtrace()
		));
		$view->show();
	}
	
	/**
	 * @desc Shows 404 error (Not found)
	 * @return void
	 */
	public function e404() {
		$this->error(404);
	}

	/**
	 * @desc Shows 403 error (Forbidden)
	 * @return void
	 */
	public function e403() {
		$this->error(403);
	}

	/**
	 * @desc Shows 500 error (Internal server error)
	 * @return void
	 */
	public function e500() {
		$this->error(500);
	}
}