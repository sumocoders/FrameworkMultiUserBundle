<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserWithPasswordRepository;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class AbstractUserHandler implements Handler
{
    /**
     * @param UserRepositoryCollection $userRepositoryCollection
     * @param UserInterface $user
     *
     * @return UserRepository|UserWithPasswordRepository
     */
    protected function getUserRepositoryForUser(
        UserRepositoryCollection $userRepositoryCollection,
        UserInterface $user
    ) {
        return $userRepositoryCollection->findRepositoryByClassName(get_class($user));
    }
}
