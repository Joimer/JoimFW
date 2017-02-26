<?php

namespace Http\Response;

class Sender {

	protected $response;

	public function __construct(IResponse $response) {
		$this->response = $response;
	}

	public function send() {
		$this->response->headers();
		$this->response->show();
	}
}
