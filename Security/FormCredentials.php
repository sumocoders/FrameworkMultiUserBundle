<?php

namespace SumoCoders\FrameworkMultiUserBundle\Security;

class FormCredentials
{
    /** @var string */
    private $plainPassword;

    /** @var string */
    private $username;

    /**
     * @param string $username
     * @param string $plainPassword
     */
    public function __construct($username, $plainPassword)
    {
        $this->username = $username;
        $this->plainPassword = $plainPassword;
    }

    /**
     * Returns the username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Returns the plain password
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
}
