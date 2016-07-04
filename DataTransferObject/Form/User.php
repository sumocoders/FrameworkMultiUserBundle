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
        $userTransferObject = new self();
        $userTransferObject->id = $user->getId();
        $userTransferObject->userName = $user->getUsername();
        $userTransferObject->displayName = $user->getDisplayName();
        $userTransferObject->email = $user->getEmail();

        return $userTransferObject;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return UserEntity::class;
    }
}
