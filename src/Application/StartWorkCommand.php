<?php
namespace Robincw\Worker\Application;

use Robincw\Worker\Domain\Worker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartWorkCommand extends Command
{
    const NAME = 'start';
    const DESCRIPTION = 'Starts work';

    /** @var Worker */
    protected $worker;

    /**
     * @param Worker $worker
     */
    public function __construct(Worker $worker)
    {
        parent::__construct();
        $this->worker = $worker;
    }

    protected function configure()
    {
        $this->setName(self::NAME);
        $this->setDescription(self::DESCRIPTION);
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Starting work");
        $this->worker->work();
        $output->writeln("Finished work");
        return 0;
    }
}