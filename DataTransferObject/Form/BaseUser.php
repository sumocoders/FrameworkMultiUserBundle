<?php

namespace SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Form;

use SumoCoders\FrameworkMultiUserBundle\User\User as UserEntity;

class BaseUser extends User
{
    /**
     * @var string
     */
    public $password = '';

    /**
     * @param UserEntity $user
     *
     * @return User
     */
    public static function fromUser(UserEntity $user)
    {
        $baseUserTransferObject = new self();
        $baseUserTransferObject->id = $user->getId();
        $baseUserTransferObject->userName = $user->getUsername();
        $baseUserTransferObject->displayName = $user->getDisplayName();
        $baseUserTransferObject->email = $user->getEmail();
        $baseUserTransferObject->password = $user->getPassword();

        return $baseUserTransferObject;
    }
}
