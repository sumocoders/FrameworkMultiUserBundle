<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

interface PasswordResetInterface
{
    /**
     * @return self
     */
    public function clearPasswordResetToken();

    /**
     * @return self
     */
    public function generatePasswordResetToken();

    /**
     * @return string
     */
    public function getPasswordResetToken();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return self
     */
    public function setEmail($email);

    /**
     * @param $password
     *
     * @return self
     */
    public function setPassword($password);
}
