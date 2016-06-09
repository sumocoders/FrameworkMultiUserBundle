<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\Exception\NoRepositoriesRegisteredException;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

final class CreateUserCommand extends Command
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
        $userClass = $input->getOption('class');

        $availableUserClasses = $this->getAllValidUserClasses();

        if (count($availableUserClasses) == 1) {
            $userClass = $availableUserClasses[0];
        }

        if (!isset($userClass)) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion(
                'Please select the user class',
                $availableUserClasses,
                0
            );

            $userClass = $helper->ask($input, $output, $question);
        }

        $repository = $this->getRepository($userClass);

        $handler = new CreateUserHandler($repository);

        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $displayName = $input->getArgument('displayName');

        $command = new CreateUser($username, $password, $displayName);

        $handler->handle($command);

        $output->writeln($username . ' has been created');
    }

    /**
     * @throws NoRepositoriesRegisteredException
     *
     * @return array
     */
    private function getAllValidUserClasses()
    {
        if (count($this->userRepositoryCollection->all()) === 0) {
            throw new NoRepositoriesRegisteredException('No user repositories registered');
        }

        $validClasses = [];

        foreach ($this->userRepositoryCollection->all() as $repository) {
            $validClasses[] = $repository->getSupportedClass();
        }

        return $validClasses;
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
