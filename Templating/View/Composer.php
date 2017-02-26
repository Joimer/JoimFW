<?php

namespace Templating\View;

use \Serialization\IStringable;

class Composer
{

	protected $composedView;

	public function __construct(IStringable $parent, string $name, IStringable $child) {
		$parent->parse($name, (string) $child);
		$this->composedView = $parent;
	}

	public function getView() : IStringable {
		return $this->composedView;
	}
}
