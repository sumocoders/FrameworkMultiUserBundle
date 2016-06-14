<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\Exception\InterfaceNotImplemented;
use SumoCoders\FrameworkMultiUserBundle\User\PasswordResetInterface;
use SumoCoders\FrameworkMultiUserBundle\User\UserInterface;

class PasswordResetRequest
{
    /**
     * @var UserInterface
     */
    private $user;

    public function __construct(UserInterface $user)
    {
        if (! $user instanceof PasswordResetInterface) {
            throw new InterfaceNotImplemented('The user doesn\'t implement PasswordResetInterface');
        }

        $this->user = $user;
    }
    
    public function getUser()
    {
        return $this->user;
    }
}