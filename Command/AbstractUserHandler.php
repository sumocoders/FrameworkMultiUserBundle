<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\BaseUserRepositoryCollection;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;

abstract class AbstractUserHandler implements Handler
{
    /**
     * @param BaseUserRepositoryCollection $userRepositoryCollection
     * @param User $user
     *
     * @return UserRepository
     */
    protected function getUserRepositoryForUser(
        BaseUserRepositoryCollection $userRepositoryCollection,
        User $user
    ) {
        return $userRepositoryCollection->findRepositoryByClassName(get_class($user));
    }
}
