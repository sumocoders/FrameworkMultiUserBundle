<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\User;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteUser
{
    /**
     * @var User
     * @Assert\NotNull()
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
