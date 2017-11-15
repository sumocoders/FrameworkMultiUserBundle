<?php

namespace SumoCoders\FrameworkMultiUserBundle\Security;

class FormCredentials
{
    /** @var string */
    private $plainPassword;

    /** @var string */
    private $username;

    public function __construct(string $username, string $plainPassword)
    {
        $this->username = $username;
        $this->plainPassword = $plainPassword;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }
}
