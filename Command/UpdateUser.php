<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\User;

class UpdateUser
{
    /**
     * @var User
     */
    private $user;

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
     * UpdateUser constructor.
     *
     * @param User $user
     * @param $username
     * @param $password
     * @param $displayName
     */
    public function __construct(User $user, $username, $password, $displayName)
    {
        $this->user = $user;
        $this->username = $username;
        $this->password = $password;
        $this->displayName = $displayName;
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
