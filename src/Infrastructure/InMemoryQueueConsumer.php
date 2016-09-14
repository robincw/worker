<?php

namespace Robincw\Worker\Infrastructure;

use Robincw\Worker\Domain\Consumer;

class InMemoryQueueConsumer implements Consumer
{
    /** var InMemoryQueue */
    private $q;

    public function __construct(InMemoryQueue $q) {
        $this->q = $q;
    }

    public function consume()
    {
        while($this->q->isEmpty()) {}
        return $this->q->get();
    }
}
