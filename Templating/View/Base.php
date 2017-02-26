<?php

namespace Templating\View;

use \Serialization\IStringable;
use \Templating\View;
use Templating\View\Composer;

class Base implements IStringable {

	protected $view;

	public function __construct() {
		$this->view = new View('main/base');
	}

	public function addHeader(IStringable $header) : Base {
		return $this->addPart('header', $header);
	}

	public function addFooter(IStringable $footer) : Base {
		return $this->addPart('footer', $footer);
	}

	public function addContent(IStringable $content) : Base {
		return $this->addPart('content', $content);
	}

	protected function addPart(string $name, IStringable $content) : Base {
		$composer = new Composer($this->view, $name, $content);
		$this->view = $composer->getView();
		return $this;
	}

	public function __toString() : string {
		return $this->view->show();
	}
}
