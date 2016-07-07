<?php

namespace SumoCoders\FrameworkMultiUserBundle\DataTransferObject;

use SumoCoders\FrameworkMultiUserBundle\User\User;
use SumoCoders\FrameworkMultiUserBundle\User\UserWithPassword;

class UserWithPasswordDataTransferObject implements UserDataTransferObject
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
     * @var User
     */
    private $user;

    /**
     * @param User $user
     *
     * @return User
     */
    public static function fromUser(User $user)
    {
        $baseUserTransferObject = new self();
        $baseUserTransferObject->user = $user;
        $baseUserTransferObject->id = $user->getId();
        $baseUserTransferObject->userName = $user->getUsername();
        $baseUserTransferObject->displayName = $user->getDisplayName();
        $baseUserTransferObject->email = $user->getEmail();

        return $baseUserTransferObject;
    }

    /**
     * @return UserWithPassword
     */
    public function getEntity()
    {
        $this->user->change(
            $this->userName,
            $this->plainPassword,
            $this->displayName,
            $this->email
        );

        return $this->user;
    }
}