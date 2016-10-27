<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;

abstract class AbstractUserHandler implements Handler
{
    /**
     * @param UserRepositoryCollection $userRepositoryCollection
     * @param User $user
     *
     * @return UserRepository
     */
    protected function getUserRepositoryForUser(
        UserRepositoryCollection $userRepositoryCollection,
        User $user
    ) {
        return $userRepositoryCollection->findRepositoryByClassName(get_class($user));
    }
}
