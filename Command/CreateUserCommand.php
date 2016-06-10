<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateUserCommand extends UserCommand
{
    /**
     * @var UserRepositoryCollection
     */
    private $userRepositoryCollection;

    /**
     * @var CreateUserHandler
     */
    private $handler;

    /**
     * CreateUserCommand constructor.
     *
     * @param UserRepositoryCollection $userRepositoryCollection
     * @param CreateUserHandler $handler
     */
    public function __construct(UserRepositoryCollection $userRepositoryCollection, CreateUserHandler $handler)
    {
        parent::__construct();
        $this->userRepositoryCollection = $userRepositoryCollection;
        $this->handler = $handler;
    }

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
            ->addOption(
                'class',
                null,
                InputOption::VALUE_OPTIONAL,
                'The class off the user'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $availableUserClasses = $this->getAllValidUserClasses($this->userRepositoryCollection);

        $userClass = $this->setUserClass($input, $output, $availableUserClasses);

        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $displayName = $input->getArgument('displayName');

        $command = new CreateUser($username, $password, $displayName);

        $this->handler->handle($command, $userClass);

        $output->writeln($username . ' has been created');
    }
}
