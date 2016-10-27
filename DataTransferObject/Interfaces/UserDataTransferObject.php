<?php

namespace SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces;

use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;

interface UserDataTransferObject
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getUserName();

    /**
     * @return string
     */
    public function getDisplayName();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return string
     */
    public function getPlainPassword();

    /**
     * @param User $user
     *
     * @return self
     */
    public static function fromUser(User $user);

    /**
     * @return User
     */
    public function getEntity();
}
