<?php

namespace SumoCoders\FrameworkMultiUserBundle\DataTransferObject;

use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserWithPassword as UserWithPasswordInterface;
use SumoCoders\FrameworkMultiUserBundle\User\UserWithPassword;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces\UserWithPasswordDataTransferObject
    as UserWithPasswordDataTransferObjectInterface;

class UserWithPasswordDataTransferObject implements UserWithPasswordDataTransferObjectInterface
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $userName;

    /**
     * @var string
     */
    public $displayName;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $plainPassword;

    /**
     * @var UserWithPassword
     */
    private $user;

    /**
     * @param UserWithPasswordInterface $user
     *
     * @return UserWithPasswordDataTransferObjectInterface
     */
    public static function fromUser(UserWithPasswordInterface $user)
    {
        $baseUserTransferObject = new self();
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

    /**
     * @return UserWithPassword
     */
    public function getEntity()
    {
        if ($this->user) {
            $this->user->change($this);

            return $this->user;
        }

        return new UserWithPassword(
            $this->userName,
            $this->plainPassword,
            $this->displayName,
            $this->email
        );
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
}
