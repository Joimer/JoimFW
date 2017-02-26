<?php

namespace Serialization;

interface IReader {

	public function read(string $serialized) : array;
}
