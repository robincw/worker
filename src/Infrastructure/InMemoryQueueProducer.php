<?php

namespace Robincw\Worker\Infrastructure;

use Robincw\Worker\Domain\Producer;

class InMemoryQueueProducer implements Producer
{
	/** var InMemoryQueue */
	private $q;

	public function __construct(InMemoryQueue $q) {
		$this->q = $q;
	}

    public function produce($message)
    {
        $this->q->put($message);
    }
}
