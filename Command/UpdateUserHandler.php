<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\UserDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;

final class UpdateUserHandler extends AbstractUserHandler
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
     * @param UserDataTransferObject $userDataTransferObject
     */
    public function handle(UserDataTransferObject $userDataTransferObject)
    {
        $userEntity = $userDataTransferObject->getEntity();

        $repository = $this->getUserRepositoryForUser($this->userRepositoryCollection, $userEntity);
        $repository->update($userEntity);
    }
}
