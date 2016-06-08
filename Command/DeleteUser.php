<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\User;

class DeleteUser
{
    /**
     * @var User
     */
    private $user;

    /**
     * DeleteUser constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
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
