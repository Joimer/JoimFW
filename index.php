<?php
/**
 * This is the index page. All requests go here through a simple RewriteRule to be processed depending on the query string.
 **/
try {
	// Autoload class
	require('autoload.php');
	// The FrameWork class to bootstrap the application
	require('bootstrap.php');
	// We are ready, let's load the whole thing
	$session = new sessionHandler();
	$session->start();
	JoimFW::config();
	// Example of cookie usage to log in an user
	$cookie = cookieHandler::getUserCookie();
	cookieHandler::logInUserByCookie();
	JoimFW::load(JoimFW::getVars(configHandler::get('aliases')));
} catch (ErrorException $e) {
	// Something happened, let's catch and handle the error
	JoimFW::execError($e);
}
?>
