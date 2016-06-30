<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;

final class CreateUserHandler extends UserHandler
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
     * @param CreateUser $command
     */
    public function handle(CreateUser $command, $class)
    {
        $user = new $class(
            $command->getUsername(),
            $command->getPassword(),
            $command->getDisplayName(),
            $command->getEmail()
        );
        $repository = $this->getUserRepositoryForUser($this->userRepositoryCollection, $user);
        $repository->add($user);
    }
}
