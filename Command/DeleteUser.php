<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\UserInterface;

final class DeleteUser
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * DeleteUser constructor.
     *
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Get the User.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
