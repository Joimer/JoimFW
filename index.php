<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require('autoload.php');
$application = new Application();
$application->main();
