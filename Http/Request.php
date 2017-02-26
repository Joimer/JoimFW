<?php

namespace Http;

class Request implements IRequest {

	protected $request;

	public function __construct(array $request) {
		$this->request = $request;
	}

	public function getValues() : array {
		return $this->request;
	}

	public function get(string $name) : string {
		$value = '';
		if (isset($this->request[$name])) {
			$value = $this->request[$name];
		}

		return $value;
	}
}
