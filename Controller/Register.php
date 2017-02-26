<?php

namespace Controller;

use \Http\Response\Html;
use \Http\Response\IResponse;
use \Templating\View\Register as RegisterView;

class Register implements IController {

	public function run() : IResponse {
		$view = new RegisterView();
		return new Html($view);
	}
}
