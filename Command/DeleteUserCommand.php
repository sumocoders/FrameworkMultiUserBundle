<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class DeleteUserCommand extends UserCommand
{
    /**
     * @var UserRepositoryCollection
     */
    private $userRepositoryCollection;

    /**
     * @var DeleteUserHandler
     */
    private $handler;

    /**
     * DeleteUserCommand constructor.
     *
     * @param UserRepositoryCollection $userRepositoryCollection
     * @param DeleteUserHandler $handler
     */
    public function __construct(UserRepositoryCollection $userRepositoryCollection, DeleteUserHandler $handler)
    {
        parent::__construct();
        $this->userRepositoryCollection = $userRepositoryCollection;
        $this->handler = $handler;
    }

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
            ->addOption(
                'class',
                null,
                InputOption::VALUE_OPTIONAL,
                'The class off the user',
                'SumoCoders\FrameworkMultiUserBundle\User\User'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $availableUserClasses = $this->getAllValidUserClasses($this->userRepositoryCollection);

        $userClass = $this->getUserClass($input, $output, $availableUserClasses);

        $repository = $this->getRepository($userClass);

        $username = $input->getArgument('username');
        $user = $repository->findByUsername($username);

        if (!$user) {
            $output->writeln('<error>'.$username.' doesn\'t exists');

            return;
        }

        $command = new DeleteUser($user);

        $this->handler->handle($command);

        $output->writeln($username . ' has been deleted');
    }

    /**
     * Get the repository for the user's Class.
     *
     * @param $userClass
     *
     * @return UserRepository
     */
    private function getRepository($userClass)
    {
        return $this->userRepositoryCollection->findRepositoryByClassName($userClass);
    }
}
