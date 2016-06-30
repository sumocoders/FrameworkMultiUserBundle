<?php

namespace SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Form;

use SumoCoders\FrameworkMultiUserBundle\User\User as UserEntity;

class User implements UserInterface
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

        return $dataTransferObject;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return UserEntity::class;
    }
}
