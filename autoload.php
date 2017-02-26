<?php
require('Application/ILoader.php');
require('Application/Loader.php');
spl_autoload_register(['Application\Loader', 'load']);
