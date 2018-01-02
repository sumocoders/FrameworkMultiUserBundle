<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces\UserDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\User\BaseUserRepositoryCollection;

final class DeleteUserHandler extends AbstractUserHandler
{
    /** @var BaseUserRepositoryCollection */
    private $userRepositoryCollection;

    public function __construct(BaseUserRepositoryCollection $userRepositoryCollection)
    {
        $this->userRepositoryCollection = $userRepositoryCollection;
    }

    public function handle(UserDataTransferObject $user): void
    {
        $userEntity = $user->getEntity();

        $repository = $this->getUserRepositoryForUser($this->userRepositoryCollection, $userEntity);
        $repository->delete($userEntity);
    }
}
