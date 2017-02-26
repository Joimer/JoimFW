<?php

namespace Application\Error;

interface IHandler {
	public static function handle($errno, $errstr, $errfile, $errline);
}
