<?php

namespace App\Command;

use App\Entity\Post;
use App\Validator\ContainsAlphanumeric;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use LogicException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class WorkflowCommand extends Command
{
    protected static $defaultName = 'app:post-flow';

    private $entityManager;

    private $workflow;

    public function __construct(EntityManagerInterface $entityManager, WorkflowInterface $postPublishingWorkflow)
    {
        $this->entityManager = $entityManager;
        $this->workflow = $postPublishingWorkflow;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Creates New Post')
            ->setHelp('This command will creates new post')
            ->addArgument('title', InputArgument::REQUIRED, 'Post Title')
            ->addArgument('body', InputArgument::REQUIRED, 'Post Body');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // $section = $output->section();
        // $command = $this->getApplication()->find('hello:world');
        // $command->run(new ArrayInput([]), $output);
        $output->writeln(['Create new post', '============', '']);
        // $section->writeln('Ohhh...');
        // $section->writeln('The post is created successfully..!');
        // $section->clear();
        $constraints = new ContainsAlphanumeric();
        // $erros = $this->validator->validate($input->getArgument('body'), $constraints);
        // if (count($erros) !== 0) {
        //     $output->writeln('Ohhh...');
        //     $output->writeln('Invalid post body contents');
        //     return Command::FAILURE;
        // }
        $post = new Post();
        $post->setTitle($input->getArgument('title'));
        $post->setBody($input->getArgument('body'));
        $this->entityManager->persist($post);
        // try {
        //     $this->entityManager->flush();
        // } catch (ORMException $e) {
        //     $output->writeln('Ohhh...');
        //     $output->writeln('unabel to add the post');

        //     return Command::FAILURE;
        // }
        // $this->workflow = $containaer->get('workflow.post_publishing');

        $output->writeln($this->workflow->can($post, 'publish'));

        $output->writeln($this->workflow->can($post, 'to_rewview'));

        try {
            $this->workflow->apply($post, 'to_review');
        } catch (LogicException $exception) {
            // ...
        }

        $transitions = $this->workflow->getEnabledTransitions($post);

        $transition = $this->workflow->getEnabledTransition($post, 'publish');
        $output->writeln('Ohhh... ');
        $output->writeln('The post '.$input->getArgument('title').' is created successfully..!');

        return Command::SUCCESS;
    }
}
