<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Form\UserInterface;
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
     * @param UserInterface $user
     */
    public function handle(UserInterface $user)
    {
        $class = $user->getClass();

        $newUser = new $class(
            $user->userName,
            $user->password,
            $user->displayName,
            $user->email
        );

        $repository = $this->getUserRepositoryForUser($this->userRepositoryCollection, $newUser);
        $repository->add($newUser);
    }
}
