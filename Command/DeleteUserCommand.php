<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class DeleteUserCommand extends ContainerAwareCommand
{
    /**
     * @var UserRepositoryCollection
     */
    private $userRepositoryCollection;

    /**
     * @param UserRepositoryCollection $userRepositoryCollection
     */
    public function __construct(UserRepositoryCollection $userRepositoryCollection)
    {
        parent::__construct();
        $this->userRepositoryCollection = $userRepositoryCollection;
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
        $userClass = $input->getOption('class');

        $repository = $this->getRepository($userClass);
        
        $username = $input->getArgument('username');
        $user = $repository->findByUsername($username);

        if (!$user) {
            $output->writeln('<error>'.$username.' doesn\'t exists');
            return;
        }

        $command = new DeleteUser($user);
        
        $handler = new DeleteUserHandler($repository);
        $handler->handle($command);

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
