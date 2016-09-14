<?php
namespace Robincw\Worker\Application;

use Robincw\Worker\Domain\MessageGenerator;
use Robincw\Worker\Domain\Worker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestQueueCommand extends Command
{
    const NAME = 'test';
    const DESCRIPTION = 'Generates a number of test messages and consumes them';

    /** @var MessageGenerator */
    protected $generator;

    /** @var Worker */
    protected $worker;

    /**
     * @param MessageGenerator $generator
     */
    public function __construct(MessageGenerator $generator, Worker $worker)
    {
        parent::__construct();
        $this->generator = $generator;
        $this->worker = $worker;
    }

    protected function configure()
    {
        $this->setName(self::NAME);
        $this->setDescription(self::DESCRIPTION);

        $this->addArgument('numberOfMessages', InputArgument::REQUIRED, 'The number of messages to generate');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $numberOfMessages = $input->getArgument('numberOfMessages');
        $output->writeln("Generating $numberOfMessages messages");
        $this->generator->generate($numberOfMessages);
        $output->writeln("Finished generating messages");
        $output->writeln("Starting work");
        $this->worker->work();
        $output->writeln("Finished work");
        return 0;
    }
}