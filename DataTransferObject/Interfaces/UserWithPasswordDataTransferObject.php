<?php

namespace SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces;

use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserWithPassword;

interface UserWithPasswordDataTransferObject
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
     * @param UserWithPassword $user
     *
     * @return self
     */
    public static function fromUser(UserWithPassword $user);

    /**
     * @return UserWithPassword
     */
    public function getEntity();
}
