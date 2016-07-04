<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\UserInterface;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;

abstract class UserHandler implements Handler
{
    protected function getUserRepositoryForUser(UserRepositoryCollection $userRepositoryCollection, UserInterface $user)
    {
        return $userRepositoryCollection->findRepositoryByClassName(get_class($user));
    }
}
