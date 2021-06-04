<?php

namespace App\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class HelloWorldCommand extends Command
{
    protected static $defaultName = "hello:world";

    public function __construct(LoggerInterface $logger)
    {
        $logger->info("Hello world command is invoked");
        parent::__construct();
    }

    public function configure()
    {
        $this->setDescription("Prints 'Hello world'");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('welcome');
        // $user = $io->ask('hello your name...', '...');
        $user = "...";
        if ($output->isVerbose()) {
            $io->note('Verbose mode...');
        }
        $io->progressStart();
        $text = "Hello, World";
        $io->progressAdvance(50);
        $text .= $user;
        $io->progressAdvance(50);
        $text .= "...";
        $io->progressFinish();
        $io->info($text);
        $io->success("Executed Successfully..!");
        // $output->writeln("Hello world");
        return Command::SUCCESS;
    }
}
