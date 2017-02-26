<?php

namespace Controller;

use \Http\Response\IResponse;

interface IController {

	public function run() : IResponse;
}
