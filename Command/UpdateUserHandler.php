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

        $username = $command->getUsername();
        $password = $command->getPassword();
        $displayname = $command->getDisplayName();
        $email = $command->getEmail();
        $token = $user->getPasswordResetToken();
        $id = $user->getId();

        $user = new User($username, $password, $displayname, $email, $id, $token);
        $repository = $this->getUserRepositoryForUser($this->userRepositoryCollection, $user);
        $repository->update($user);
    }
}
