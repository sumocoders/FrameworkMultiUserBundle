<?php

namespace SumoCoders\FrameworkMultiUserBundle\User\Interfaces;

use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;

interface PasswordReset
{
    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return PasswordResetToken
     */
    public function getPasswordResetToken();

    /**
     * @param $password
     *
     * @return self
     */
    public function setPassword($password);

    /**
     * @return self
     */
    public function generatePasswordResetToken();

    /**
     * @return self
     */
    public function clearPasswordResetToken();
}
