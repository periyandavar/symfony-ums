<?php

namespace App\Test;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CreatePostCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $command = $application->find('app:create-post');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['title' => 'carrot', 'body' => 'vegetable']);
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString("The post carrot is created successfully", $output);
    }
}
