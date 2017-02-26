<?php

namespace Http\Response;

use \Serialization\IStringable;

interface IResponse {

	public function __construct(IStringable $content);

	public function headers();

	public function show();
}
