<?php

namespace Application;

class Router implements IRouter {

	protected $route;
	// TODO: Move to a config json?
	private $routes = [
		'' => '\Controller\Home',
		'/' => '\Controller\Home',
		'/home' => '\Controller\Home',
		'/register' => '\Controller\Register'
	];

	public function __construct(string $route='') {
		$this->setRoute($route);
	}

	public function setRoute(string $route) {
		$this->route = $route;
	}

	public function route() : string {
		if (isset($this->routes[$this->route])) {
			return $this->routes[$this->route];
		}

		return '\Controller\NotFound';
	}
}
