<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\User;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;

abstract class AbstractUserHandler implements Handler
{
    protected function getUserRepositoryForUser(
        UserRepositoryCollection $userRepositoryCollection,
        User $user
    ) {
        return $userRepositoryCollection->findRepositoryByClassName(get_class($user));
    }
}
