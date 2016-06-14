<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

final class CreateUser
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $displayName;

    /**
     * @var string
     */
    private $email;

    /**
     * CreateUser constructor.
     *
     * @param $username
     * @param $password
     * @param $displayName
     */
    public function __construct($username, $password, $displayName, $email)
    {
        $this->username = $username;
        $this->password = $password;
        $this->displayName = $displayName;
        $this->email = $email;
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

    /**
     * Get the email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
