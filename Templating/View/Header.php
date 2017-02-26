<?php

namespace Templating\View;

use \Serialization\IStringable;
use \Templating\View;

class Header implements IStringable {

	protected $view;

	public function __construct() {
		$this->view = new View('main/header');
	}

	public function __toString() : string {
		return $this->view->show();
	}
}
