<?php

namespace Serialization\Json;

use Serialization\IReader;

class Reader implements IReader {

	public function read(string $json) : array {
		return json_decode($json, true);
	}
}
