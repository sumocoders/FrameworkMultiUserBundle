<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\User;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;

final class UpdateUserHandler extends UserHandler
{
    /**
     * @var UserRepositoryCollection
     */
    private $userRepositoryCollection;

    /**
     * CreateUserHandler constructor.
     *
     * @param UserRepositoryCollection $userRepositoryCollection
     */
    public function __construct(UserRepositoryCollection $userRepositoryCollection)
    {
        $this->userRepositoryCollection = $userRepositoryCollection;
    }

    /**
     * @param UpdateUser $command
     */
    public function handle(UpdateUser $command)
    {
        $user = $command->getUser();

        $user = new User(
            $command->getUsername(),
            $command->getPassword(),
            $command->getDisplayName(),
            $command->getEmail(),
            $user->getId(),
            $user->getPasswordResetToken()
        );
        $repository = $this->getUserRepositoryForUser($this->userRepositoryCollection, $user);
        $repository->update($user);
    }
}
