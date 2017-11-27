<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\BaseUserRepositoryCollection;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;

abstract class AbstractUserHandler implements Handler
{
    protected function getUserRepositoryForUser(
        BaseUserRepositoryCollection $userRepositoryCollection,
        User $user
    ): UserRepository {
        return $userRepositoryCollection->findRepositoryByClassName(get_class($user));
    }
}
