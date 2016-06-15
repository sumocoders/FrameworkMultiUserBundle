<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;

class User implements UserInterface, PasswordReset
{
    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /** @var string */
    private $displayName;

    /** @var PasswordResetToken */
    private $passwordResetToken;

    /** @var string */
    private $email;

    /**
     * @var int
     */
    private $id;

    /**
     * @param string $username
     * @param string $password
     * @param string $displayName
     * @param $email
     * @param PasswordResetToken $token
     */
    public function __construct($username, $password, $displayName, $email, $id = null, PasswordResetToken $token = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->displayName = $displayName;
        $this->email = $email;
        
        if ($token) {
            $this->passwordResetToken = $token;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return [ 'ROLE_USER' ];
    }

    /**
     * {@inheritDoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritDoc}
     */
    public function getSalt()
    {
        return;
    }

    /**
     * {@inheritDoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritDoc}
     */
    public function eraseCredentials()
    {
        return;
    }

    /**
     * {@inheritDoc}
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return $this->getDisplayName();
    }

    /**
     * {@inheritdoc}
     */
    public function clearPasswordResetToken()
    {
        $this->passwordResetToken = null;

        return $this;
    }

    /**
     * @return self
     */
    public function generatePasswordResetToken()
    {
        $this->passwordResetToken = PasswordResetToken::generate();

        return $this;
    }

    /**
     * @return string
     */
    public function getPasswordResetToken()
    {
        return $this->passwordResetToken;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
