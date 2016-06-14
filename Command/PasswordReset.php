<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\UserInterface;

class PasswordReset
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $passwordConfirmation;

    public function __construct(UserInterface $user, $password, $passwordConfirmation)
    {
        $this->user = $user;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function passwordConfirmationIsValid()
    {
        if ($this->passwordConfirmation !== $this->password) {
            return false;
        }

        return true;
    }
}
