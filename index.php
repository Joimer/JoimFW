<?php
// Total error reporting. No error, even an E_NOTICE, shall be accepted.
error_reporting(E_ALL);
// Require the autoload class to autoload all classes called in start up
require_once('library/JoimFW/Joim_Load.php');
// Try-catch block that executes the whole application.
try {
	Joim_Load::register();
	Joim_Bootstrap::init();
} catch (ErrorException $e) {
	// Something happened, let's catch and handle the error
	Joim_Error::execError($e);
}