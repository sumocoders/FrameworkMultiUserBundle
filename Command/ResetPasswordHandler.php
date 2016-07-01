<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Form\ChangePassword;
use SumoCoders\FrameworkMultiUserBundle\Exception\InvalidPasswordConfirmationException;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;

class ResetPasswordHandler
{
    /**
     * @var UserRepositoryCollection
     */
    private $userRepositoryCollection;

    /**
     * PasswordResetHandler constructor.
     *
     * @param UserRepositoryCollection $userRepositoryCollection
     */
    public function __construct(UserRepositoryCollection $userRepositoryCollection)
    {
        $this->userRepositoryCollection = $userRepositoryCollection;
    }

    /**
     * @param ChangePassword $dataTransferObject
     *
     * @throws InvalidPasswordConfirmationException
     */
    public function handle(ChangePassword $dataTransferObject)
    {
        $user = $dataTransferObject->user;
        $user->setPassword($dataTransferObject->newPassword);
        $user->clearPasswordResetToken();
        $repository = $this->userRepositoryCollection->findRepositoryByClassName(get_class($user));
        $repository->update($user, $user);
    }
}
