<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\Exception\InvalidPasswordConfirmationException;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;

class PasswordResetHandler
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
     * @param ResetPassword $command
     *
     * @throws InvalidPasswordConfirmationException
     */
    public function handle(ResetPassword $command)
    {
        if (!$command->passwordConfirmationIsValid()) {
            throw new InvalidPasswordConfirmationException('The password confirmation isn\'t valid');
        }
        
        $user = $command->getUser();
        $updatedUser = clone $user;
        $updatedUser->setPassword($command->getPassword());
        $updatedUser->clearPasswordResetToken();
        $repository = $this->userRepositoryCollection->findRepositoryByClassName(get_class($user));
        $repository->update($user, $updatedUser);

        return;
    }
}
