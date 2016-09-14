<?php

namespace Robincw\Worker\Infrastructure;

class InMemoryQueue {
	/** var array */
	private $q;

	public function __construct() {
		$this->q = [];
	}

	public function put($item) {
		$this->q[] = $item;
	}

	public function get() {
		return array_shift($this->q);
	}

	public function isEmpty() {
		return count($this->q) == 0;
	}
}