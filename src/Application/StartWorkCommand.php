<?php
namespace Robincw\Worker\Application;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartWorkCommand extends Command
{
    const NAME = 'start';
    const DESCRIPTION = 'Starts work';

    /** @var string */
    protected $message;

    /**
     * @param null|string $message
     */
    public function __construct($message)
    {
        parent::__construct();
        $this->message = $message;
    }

    protected function configure()
    {
        $this->setName(self::NAME);
        $this->setDescription(self::DESCRIPTION);
        $this->addArgument('message', InputArgument::OPTIONAL, 'A message to output', $this->message);
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = $input->getArgument('message') ?: $this->message;
        $output->writeln("Started work");
        $output->writeln($message);
        $output->writeln("Finished work");
        return 0;
    }
}