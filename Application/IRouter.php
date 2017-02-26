<?php

namespace Application;

interface IRouter {
	public function setRoute(string $route);

	public function route() : string;
}
