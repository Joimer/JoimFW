<?php
function __autoload($className) {
		switch ($className) {
			case (stripos($className, 'Zend') !== false):
				$className = str_replace('_', '/', $className);
				require_once("{$className}.php");
				break;
			case (stripos($className, 'controller') !== false):
				if (file_exists("controllers/{$className}.php")) {
					require_once("controllers/{$className}.php");
				} else {
					require_once("controllers/errorController.php");
					$controller = new errorController();
					$controller->e404();
				}
				break;
			case (stripos($className, 'model') !== false):
				require_once("models/{$className}.php");
				break;
			case (stripos($className, 'handler') !== false):
				require_once("handlers/{$className}.php");
				break;
			case (stripos($className, 'cron') !== false):
				require_once("crons/{$className}.php");
				break;
		}
	}
?>
