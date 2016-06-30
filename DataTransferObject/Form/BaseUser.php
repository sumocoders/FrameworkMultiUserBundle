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
        $dataTransferObject = new self();
        $dataTransferObject->id = $user->getId();
        $dataTransferObject->userName = $user->getUsername();
        $dataTransferObject->displayName = $user->getDisplayName();
        $dataTransferObject->email = $user->getEmail();
        $dataTransferObject->password = $user->getPassword();

        return $dataTransferObject;
    }
}
