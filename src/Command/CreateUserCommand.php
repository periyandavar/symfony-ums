<?php

namespace App\Command;

use App\Entity\Post;
use App\Validator\ContainsAlphanumeric;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-post';

    private $entityManager;

    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
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
        $section = $output->section();
        $output->writeln(['Create new post', '============', '']);
        $section->writeln('Ohhh...');
        $section->writeln('The post is created successfully..!');
        $section->clear();
        $constraints = new ContainsAlphanumeric();
        $erros = $this->validator->validate($input->getArgument('body'), $constraints);
        if (count($erros) !== 0) {
            $section->writeln('Ohhh...');
            $section->writeln('Invalid post body contents');
            return Command::FAILURE;
        }
        $post = new Post();
        $post->setTitle($input->getArgument('title'));
        $post->setBody($input->getArgument('body'));
        $this->entityManager->persist($post);
        try {
            $this->entityManager->flush();
        } catch (ORMException $e) {
            $section->writeln('Ohhh...');
            $section->writeln('unabel to add the post');

            return Command::FAILURE;
        }
        $section->writeln('Ohhh...');
        $section->writeln('The post '.$input->getArgument('title').' is created successfully..!');

        return Command::SUCCESS;
    }
}
