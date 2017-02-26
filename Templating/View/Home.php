<?php

namespace Templating\View;

use \Serialization\IStringable;
use \Templating\View;

class Home implements IStringable {

	protected $view;

	public function __construct() {
		$view = new View('main/home');
		$base = new Base();
		$base->addHeader(new Header())
			->addFooter(new Footer())
			->addContent($view);
		$this->view = $base;
	}

	public function __toString() : string {
		return (string) $this->view;
	}
}
