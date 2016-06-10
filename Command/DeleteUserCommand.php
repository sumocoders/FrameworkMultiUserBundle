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

final class DeleteUserCommand extends Command
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
     * @throws NoRepositoriesRegisteredException
     *
     * @return array
     */
    private function getAllValidUserClasses()
    {
        if (count($this->userRepositoryCollection->all()) === 0) {
            throw new NoRepositoriesRegisteredException('No user repositories registered');
        }

        return array_map(
            function (UserRepository $repository) {
                return $repository->getSupportedClass();
            },
            $this->userRepositoryCollection->all()
        );
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
