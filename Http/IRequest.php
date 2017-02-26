<?php

namespace Http;

interface IRequest {

	public function getValues() : array;

	public function get(string $name) : string;
}
