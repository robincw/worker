<?php

namespace Robincw\Worker\Infrastructure;

use Psr\Log\LoggerInterface;
use Robincw\Worker\Domain\Producer;

class KafkaProducerAdapter implements Producer
{
    /** @var  \RdKafka\Topic[] */
    protected $topics;

    /** @var  LoggerInterface */
    protected $log;

    /**
     * KafkaProducerAdapter constructor.
     * @param \RdKafka\Producer $producer
     * @param \RdKafka\Topic[]           $topics
     */
    public function __construct(\RdKafka\Producer $producer, $topics, LoggerInterface $logger)
    {
        foreach($topics as $topic) {
            $this->topics[] = $producer->newTopic($topic);
        }
        $this->log = $logger;
    }

    public function produce($message)
    {
        foreach($this->topics as $topic) {
            $this->log->debug("Sending $message to " . $topic->getName(), [self::class]);
            try {
                $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
            } catch (\Exception $e) {
                $this->log->error($e->getMessage());
            }
            $this->log->debug("Sent $message to " . $topic->getName(), [self::class]);
        }
    }
}
