<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\User;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateUser
{
    /**
     * @var User
     * @Assert\NotNull()
     */
    public $user;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $username;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $password;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $displayName;
}
