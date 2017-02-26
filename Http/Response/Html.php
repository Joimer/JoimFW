<?php

namespace Http\Response;

use \Http\Response;
use \Serialization\IStringable;

class Html implements IResponse {

	protected $content = '';

	public function __construct(IStringable $content) {
		$this->content = (string) $content;
	}

	public function headers() {
		header('Content-type: text/html');
	}

	public function show() {
		echo $this->content;
	}
}
