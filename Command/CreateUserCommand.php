<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sumocoders:multiuser:create')
            ->setDescription('Create a user entity')
            ->addArgument(
                'username',
                InputArgument::REQUIRED,
                'The username of the user'
            )
            ->addArgument(
                'password',
                InputArgument::REQUIRED,
                'The password for the user'
            )
            ->addArgument(
                'displayName',
                InputArgument::REQUIRED,
                'The display name for the user'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $repository = $this->getContainer()->get('multi_user.user.repository');

        $handler = new CreateUserHandler($repository);

        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $displayName = $input->getArgument('displayName');

        $command = new CreateUser($username, $password, $displayName);

        $handler->handle($command);

        $output->writeln($username . ' has been created');
    }
}
