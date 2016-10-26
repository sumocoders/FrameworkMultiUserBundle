<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces\UserDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User as UserInterface;

class User implements UserInterface
{
    /** @var string */
    protected $username;

    /** @var string */
    protected $displayName;

    /** @var string */
    protected $email;

    /** @var int */
    protected $id;

    /**
     * @param string $username
     * @param string $displayName
     * @param string $email
     * @param int $id
     */
    public function __construct(
        $username,
        $displayName,
        $email,
        $id = null
    ) {
        $this->username = $username;
        $this->displayName = $displayName;
        $this->email = $email;
        $this->id = $id;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function __toString()
    {
        return $this->getDisplayName();
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function change(
        UserDataTransferObject $data
    ) {
        $this->username = $data->getUserName();
        $this->displayName = $data->getDisplayName();
        $this->email = $data->getEmail();
    }
}
