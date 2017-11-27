<?php

namespace SumoCoders\FrameworkMultiUserBundle\Console;

use SumoCoders\FrameworkMultiUserBundle\Command\CreateUserHandler;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\BaseUserDataTransferObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateUserCommand extends Command
{
    /** @var CreateUserHandler */
    private $handler;

    public function __construct(CreateUserHandler $handler)
    {
        parent::__construct();
        $this->handler = $handler;
    }

    protected function configure(): void
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
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                'The email address for the user'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $userTransferObject = new BaseUserDataTransferObject();
        $userTransferObject->userName = $input->getArgument('username');
        $userTransferObject->plainPassword = $input->getArgument('password');
        $userTransferObject->displayName = $input->getArgument('displayName');
        $userTransferObject->email = $input->getArgument('email');

        $this->handler->handle($userTransferObject);

        $output->writeln($userTransferObject->userName . ' has been created');
    }
}
