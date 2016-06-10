<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

abstract class UserCommand extends Command
{
    /**
     * @param UserRepositoryCollection $userRepositoryCollection
     *
     * @return array
     */
    protected function getAllValidUserClasses(UserRepositoryCollection $userRepositoryCollection)
    {
        return array_map(
            function (UserRepository $repository) {
                return $repository->getSupportedClass();
            },
            $userRepositoryCollection->all()
        );
    }

    protected function setUserClass(InputInterface $input, OutputInterface $output, array $availableUserClasses)
    {
        $userClass = $input->getOption('class');

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

        return $userClass;
    }
}
