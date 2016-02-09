<?php

namespace Controller;

/**
 * @desc Error controller
 * @author jmserrano
 * @since 2011-02-24
 */
class Error extends \Joim\Controller {
	
	/**
	 * @desc Shows generic error
	 * @return void
	 */
	public function indexAction() {
		$view = new \Joim\View('error', 'errors');
		$view->addData($this->args);
		$view->show();
	}

	/**
	 * @desc Shows a specific error given a valid error number
	 * @param int $errno
	 */
	public function errorAction($errno) {
		header('Status: ' . $this->_getErrHeader($errno));
		$view = new \Joim\View('error_to_user', 'errors');
		$view->addData([
			'code' => $errno,
			'message' => $this->_getErrorMsg($errno),
			'debug' => debug_backtrace()
		]);
		$view->show();
	}

	/**
	 * @desc Given a valid error number, returns its header name
	 * @return string
	 */
	private function _getErrHeader($errno) {
		$headers = [
			403 => '403 Forbidden',
			404 => '404 Not Found',
			500 => '500 Internal Server Error'
		];
		return $headers[$errno];
	}

	/**
	 * @desc Returns a custom tailored error message given a valid error number
	 * @return string
	 */
	private function _getErrorMsg($errno) {
		$text403 = \Joim\Session::get('userid') ? 
			'This page is restricted, only administrators can access.'
			: "You don't have permission to access this page.<br />You might either need to <a href='/register'>register</a> or it's a limited access page.";
		$messages = [
			403 => $text403,
			404 => 'This page does not exist!',
			500 => 'Internal error.<br />¡Disculpa las molestias, estamos trabajando para arreglarlo!'
		];
		return $messages[$errno];
	}
	
	/**
	 * @desc Shows 404 error (Not found)
	 * @return void
	 */
	public function e404Action() {
		$this->process('error', 404);
	}

	/**
	 * @desc Shows 403 error (Forbidden)
	 * @return void
	 */
	public function e403Action() {
		$this->process('error', 403);
	}

	/**
	 * @desc Shows 500 error (Internal server error)
	 * @return void
	 */
	public function e500Action() {
		$this->process('error', 500);
	}
}