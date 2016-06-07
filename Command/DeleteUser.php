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
    public $user;
}
