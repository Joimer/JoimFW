<?php

use Application\Config\Config;
use Application\Router;
use Application\Session;
use Http\Request;
use Http\Response\Sender;
use Serialization\Json\Reader;

class Application {

	public function main() {
		$config = new Config('config/config.json', new Reader());
		set_error_handler($config->get('error-handler'));
		date_default_timezone_set($config->get('default-timezone'));
		$session = new Session($config);
		$request = new Request($_REQUEST);
		$router = new Router($request->get('actions'));
		$controllerName = $router->route();
		$controller = new $controllerName($config, $session, $router);
		$response = $controller->run();
		$sender = new Sender($response);
		$sender->send();
	}
}
