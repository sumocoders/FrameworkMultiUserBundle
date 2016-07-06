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
    public $password = '';

    /**
     * @param User $user
     *
     * @return User
     */
    public static function fromUser(User $user)
    {
        $baseUserTransferObject = new self();
        $baseUserTransferObject->id = $user->getId();
        $baseUserTransferObject->userName = $user->getUsername();
        $baseUserTransferObject->displayName = $user->getDisplayName();
        $baseUserTransferObject->email = $user->getEmail();
        $baseUserTransferObject->password = $user->getPassword();

        return $baseUserTransferObject;
    }

    /**
     * @return UserWithPassword
     */
    public function getEntity()
    {
        return new UserWithPassword(
            $this->userName,
            $this->password,
            $this->displayName,
            $this->email,
            $this->id
        );
    }
}
