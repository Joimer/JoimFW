<?php

namespace Joim;

/**
 * @desc Error handler for the Framework
 * @author jmserrano
 * @since 2011-02-24
 * @modified 2014-10-13
 */
class Error {

	/**
	 * @desc Application error handler
	 * @see self::execError
	 */
	public static function errorHandler($errno, $errstr, $errfile, $errline) {
		self::execError(
			new \ErrorException($errstr . "\n" . debug_backtrace(), 0, $errno, $errfile, $errline)
		);
	}

	/**
	 * @desc Loads an execution error
	 * @param object $e Exception | ErrorException
	 * @return void
	 * @TODO
	 */
	public static function execError($e) {
		//$controller = new Joim_Error_Controller();
		$errortext = date('[Y-m-d H:i:s] ')
		. "\nError: " . $e->getMessage() . "\n"
		. 'En: ' . $e->getFile() . ':' . $e->getLine() . "\n"
		. "Traza:\n" . $e->getTraceAsString() . "\n"
		. "-------------------\n\n";
		//logHandler::log($errortext);
		/*mailHandler::mail(
			'MK3 Error Mailer <joimpoke@gmail.com>',
			date('[H:i:s d-m-Y] ') . 'Report de errores: Error en MK3',
			"Ha habido un error en MK3.\nEl error ha sido:\n------------------\n"
			. $errortext
		);*/
		//$controller->error(500);
		print_r($errortext);
	}

	/**
	 * @desc Given a valid error number, returns its header name
	 * @param int $errno
	 * @return string
	 */
	public static function getErrHeader($errno) {
		$headers = [
			403 => '403 Forbidden',
			404 => '404 Not Found',
			500 => '500 Internal Server Error'
		];
		return $headers[$errno];
	}

	/**
	 * @desc Returns a custom tailored error message given a valid error number
	 * @param int $errno
	 * @return string
	 */
	private function getErrorMsg($errno) {
		$text403 = (sessionHandler::get('userid')) ? 
			'This page is restricted, only administrators can access.'
			: "You don't have permission to access this page.<br />You might either need to <a href='/register'>register</a> or it's a limited access page.";
		$messages = [
			403 => $text403,
			404 => 'This page does not exist!',
			500 => 'Internal error.<br />¡Disculpa las molestias, estamos trabajando para arreglarlo!'
		];
		return $messages[$errno];
	}
}
