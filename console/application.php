<?php

use App\Command\HelloWorldCommand;
use Monolog\Logger;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\CommandLoader\ContainerCommandLoader;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

require_once 'vendor/autoload.php';

// $command = new HelloWorldCommand(new Logger('samp'));
$app = new Application();
// $app->add($command);
$commandLoader = new FactoryCommandLoader([
    'hello:world' => function () {
        return new HelloWorldCommand(new Logger('samp'));
    },
]);

$containerBuilder = new ContainerBuilder();
$containerBuilder->register(HelloWorldCommand::class);
$containerBuilder->compile();

// $commandLoader = new ContainerCommandLoader($containerBuilder, ['hello:world' => HelloWorldCommand::class]);

$app->setCommandLoader($commandLoader);
// $app->setDefaultCommand($command->getName());\
// $app->setDefaultCommand("hello:world");
$app->run();
