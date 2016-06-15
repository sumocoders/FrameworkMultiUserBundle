<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\Exception\InterfaceNotImplemented;
use SumoCoders\FrameworkMultiUserBundle\User\PasswordReset;
use SumoCoders\FrameworkMultiUserBundle\User\UserInterface;

class PasswordResetRequest
{
    /**
     * @var UserInterface
     */
    private $user;

    public function __construct(UserInterface $user)
    {
        if (!$user instanceof PasswordReset) {
            throw new InterfaceNotImplemented('The user doesn\'t implement PasswordResetInterface');
        }

        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
