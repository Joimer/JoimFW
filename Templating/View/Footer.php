<?php

namespace Templating\View;

use \Serialization\IStringable;
use \Templating\View;

class Footer implements IStringable {

	protected $view;

	public function __construct() {
		$this->view = new View('main/footer');
	}

	public function __toString() : string {
		return $this->view->show();
	}
}
