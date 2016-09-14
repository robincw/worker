<?php

namespace Robincw\Worker\Infrastructure;

use Psr\Log\LoggerInterface;
use Robincw\Worker\Domain\Consumer;

class KafkaLowLevelConsumerAdapter implements Consumer
{
    /** @var  \RdKafka\Consumer */
    protected $consumer;

    /** @var  string[] */
    protected $topics;

    /** @var  LoggerInterface */
    protected $log;

    /**
     * KafkaLowLevelConsumerAdapter constructor.
     * @param \RdKafka\Consumer $consumer
     * @param string[]          $topics
     * @param int               $partition
     * @param LoggerInterface   $logger
     */
    public function __construct(\RdKafka\Consumer $consumer, $topics, LoggerInterface $logger, $partition = 0)
    {
        $this->consumer = $consumer;
        $this->log = $logger;
        foreach($topics as $topic) {
            $consumerTopic = $this->consumer->newTopic($topic);
            $consumerTopic->consumeStart($partition, RD_KAFKA_OFFSET_BEGINNING);
            $this->topics[] = $consumerTopic;
        }
    }

    public function consume()
    {
        $waiting = true;
        while ($waiting) {
            foreach ($this->topics as $topic) {
                $message = $topic->consume(0, 5 * 1000);
                if (empty($message)) {
                    continue;
                }
                switch ($message->err) {
                    case RD_KAFKA_RESP_ERR_NO_ERROR:
                        $topic->offsetStore($message->partition, $message->offset);
                        $waiting = false;
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
        }
        return $message->payload;
    }
}
