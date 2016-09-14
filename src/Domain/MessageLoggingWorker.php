<?php

namespace Robincw\Worker\Domain;

use Psr\Log\LoggerInterface;

class MessageLoggingWorker implements Worker
{
    /** @var  Consumer */
    protected $consumer;

    /** @var  LoggerInterface */
    protected $log;

    /**
     * @param Consumer        $consumer
     * @param LoggerInterface $log
     */
    public function __construct(Consumer $consumer, LoggerInterface $log)
    {
        $this->consumer = $consumer;
        $this->log = $log;
    }

    public function work()
    {
        while (true) {
            $message = $this->consumer->consume();
            $this->log->info("Received : " . $message, [self::class]);
        }
    }
}
