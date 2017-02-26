<?php

namespace Controller;

use \Http\Response\Html;
use \Http\Response\IResponse;
use \Templating\View\Home as View;

class Home implements IController {

	public function run() : IResponse {
		$view = new View();
		return new Html($view);
	}
}
