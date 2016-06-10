<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\Exception\NoRepositoriesRegisteredException;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Symfony\Component\Console\Command\Command;

abstract class UserCommand extends Command
{
    /**
     * @param UserRepositoryCollection $userRepositoryCollection
     *
     * @throws NoRepositoriesRegisteredException
     *
     * @return array
     */
    protected function getAllValidUserClasses(UserRepositoryCollection $userRepositoryCollection)
    {
        if (count($userRepositoryCollection->all()) === 0) {
            throw new NoRepositoriesRegisteredException('No user repositories registered');
        }

        return array_map(
            function (UserRepository $repository) {
                return $repository->getSupportedClass();
            },
            $userRepositoryCollection->all()
        );
    }
}
