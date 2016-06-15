<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\UserInterface;

final class ResetPassword
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

    /**
     * ResetPassword constructor.
     *
     * @param UserInterface $user
     * @param $password
     * @param $passwordConfirmation
     */
    public function __construct(UserInterface $user, $password, $passwordConfirmation)
    {
        $this->user = $user;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function passwordConfirmationIsValid()
    {
        if ($this->passwordConfirmation !== $this->password) {
            return false;
        }

        return true;
    }
}
