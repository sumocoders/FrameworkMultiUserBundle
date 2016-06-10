<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;

final class DeleteUserHandler extends UserHandler
{
    /**
     * @var UserRepositoryCollection
     */
    private $userRepositoryCollection;

    /**
     * DeleteUserHandler constructor.
     *
     * @param UserRepositoryCollection $userRepositoryCollection
     */
    public function __construct(UserRepositoryCollection $userRepositoryCollection)
    {
        $this->userRepositoryCollection = $userRepositoryCollection;
    }

    /**
     * @param DeleteUser $command
     */
    public function handle(DeleteUser $command)
    {
        $repository = $this->getUserRepositoryForUser($this->userRepositoryCollection, $command->getUser());
        $repository->delete($command->getUser());
    }
}
