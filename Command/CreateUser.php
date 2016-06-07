<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUser
{
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
