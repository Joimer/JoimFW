<?php
// Total error reporting. No error, even an E_NOTICE, shall be accepted.
error_reporting(E_ALL);

// Require the autoload class to automatically load all classes called in start up
require_once('library/Joim/Load.php');

// Try-catch block that executes the whole application and handles top-level errors.
try {
	Joim\Load::register();
	Joim\Bootstrap::init();
} catch (Exception $e) {
	// Something happened, let's catch the error and handle it. We expect a \Joim\Exception.
	Joim\Error::execError($e);
}
