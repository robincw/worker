<?php

namespace Robincw\Worker\Infrastructure;

use Psr\Log\LoggerInterface;
use Robincw\Worker\Domain\Consumer;

class KafkaHighLevelConsumerAdapter implements Consumer
{
    /** @var  \RdKafka\KafkaConsumer */
    protected $consumer;

    /** @var  string[] */
    protected $topics;

    /** @var  LoggerInterface */
    protected $log;

    /**
     * KafkaLowLevelConsumerAdapter constructor.
     * @param \RdKafka\KafkaConsumer $consumer
     * @param string[]          $topics
     * @param LoggerInterface   $logger
     */
    public function __construct(\RdKafka\KafkaConsumer $consumer, $topics, LoggerInterface $logger)
    {
        $this->consumer = $consumer;
        $this->log = $logger;
        $this->consumer->subscribe($topics);
        foreach($topics as $topic) {
            $consumer->assign([new \RdKafka\TopicPartition($topic, 0)]);
        }
    }

    public function consume()
    {
        while (empty($message) || $message->err != RD_KAFKA_RESP_ERR_NO_ERROR) {
            $message = $this->consumer->consume(5 * 1000);
            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    $this->log->debug("Consumed message\n", [self::class]);
                    break;
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    $this->log->debug("No more messages; will wait for more\n", [self::class]);
                    break;
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    $this->log->debug("Timed out while consuming message\n", [self::class]);
                    break;
                default:
                    $this->log->error("Timed out while consuming message\n", [self::class]);
                    break;
            }
        }
        return $message->payload;
    }
}
