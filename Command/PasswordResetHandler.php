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

    public function __construct(UserRepositoryCollection $userRepositoryCollection)
    {
        $this->userRepositoryCollection = $userRepositoryCollection;
    }

    /**
     * @param PasswordReset $command
     * 
     * @throws InvalidPasswordConfirmationException
     */
    public function handle(PasswordReset $command)
    {
        if ($command->passwordConfirmationIsValid()) {
            $user = $command->getUser();
            $updatedUser = clone $user;
            $updatedUser->setPassword($command->getPassword());
            $updatedUser->clearPasswordResetToken();
            $repository = $this->userRepositoryCollection->findRepositoryByClassName(get_class($user));
            $repository->update($user, $updatedUser);

            return;
        }

        throw new InvalidPasswordConfirmationException('The password confirmation isn\'t valid');
    }
}
