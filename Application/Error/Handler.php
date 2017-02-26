<?php

namespace Application\Error;

class Handler implements IHandler {
	public static function handle($errno, $errstr, $errfile, $errline) {
		$e = new \ErrorException($errstr . "\n" . print_r(debug_backtrace(), 1), 0, $errno, $errfile, $errline);
		$errortext = date('[Y-m-d H:i:s] ')
		. "\nError: " . $e->getMessage() . "\n"
		. 'En: ' . $e->getFile() . ':' . $e->getLine() . "\n"
		. "Traza:\n" . $e->getTraceAsString() . "\n"
		. "-------------------\n\n";
		print_r($errortext);
	}
}
