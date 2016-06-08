<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUser
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $displayName;

    /**
     * CreateUser constructor.
     *
     * @param $username
     * @param $password
     * @param $displayName
     */
    public function __construct($username, $password, $displayName)
    {
        $this->username = $username;
        $this->password = $password;
        $this->displayName = $displayName;
    }

    /**
     * Get the username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the displayName.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }
}
