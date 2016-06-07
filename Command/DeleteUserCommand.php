<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sumocoders:multiuser:delete')
            ->setDescription('Delete a user entity')
            ->addArgument(
                'username',
                InputArgument::REQUIRED,
                'The username of the user'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $repository = $this->getContainer()->get('multi_user.user.repository');

        $handler = new DeleteUserHandler($repository);

        $username = $input->getArgument('username');
        $user = $repository->findByUsername($username);

        if (!$user) {
            $output->writeln('<error>'.$username.' doesn\'t exists');
            exit;
        }

        $command = new DeleteUser();
        $command->user = $user;

        $handler->handle($command);

        $output->writeln($username . ' has been deleted');
    }
}
