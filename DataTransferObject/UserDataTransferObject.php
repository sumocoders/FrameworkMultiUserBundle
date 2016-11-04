<?php

namespace SumoCoders\FrameworkMultiUserBundle\DataTransferObject;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces\UserDataTransferObject
    as UserDataTransferObjectInterface;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User as UserInterface;
use SumoCoders\FrameworkMultiUserBundle\User\User;

class UserDataTransferObject implements UserDataTransferObjectInterface
{
    /** @var int */
    public $id;

    /** @var string */
    public $userName;

    /** @var string */
    public $displayName;

    /** @var string */
    public $email;

    /** @var string */
    public $plainPassword;

    /** @var UserInterface */
    protected $user;

    public static function fromUser(UserInterface $user)
    {
        $baseUserTransferObject = new static();
        $baseUserTransferObject->user = $user;
        $baseUserTransferObject->id = $user->getId();
        $baseUserTransferObject->userName = $user->getUsername();
        $baseUserTransferObject->displayName = $user->getDisplayName();
        $baseUserTransferObject->email = $user->getEmail();
        if ($user->hasPlainPassword()) {
            $baseUserTransferObject->plainPassword = $user->getPlainPassword();
        }

        return $baseUserTransferObject;
    }

    public function getEntity()
    {
        if ($this->user) {
            $this->user->change($this);

            return $this->user;
        }

        return new User(
            $this->userName,
            $this->plainPassword,
            $this->displayName,
            $this->email
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
}
