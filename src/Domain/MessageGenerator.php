<?php

namespace Robincw\Worker\Domain;

use Psr\Log\LoggerInterface;

class MessageGenerator
{
    /** @var  Producer */
    protected $producer;

    /** @var  LoggerInterface */
    protected $log;

    /**
     * MessageLogger constructor.
     * @param Producer        $producer
     * @param LoggerInterface $log
     */
    public function __construct(Producer $producer, LoggerInterface $log)
    {
        $this->producer = $producer;
        $this->log = $log;
    }

    public function generate($numberOfMessages = 10)
    {
        for($i=0; $i<$numberOfMessages; $i++) {
            $this->producer->produce("Message $i");
        }
    }
}
