<?php

namespace SumoCoders\FrameworkMultiUserBundle\User\Interfaces;

interface PasswordResetRepository
{
    /**
     * @param string $token
     *
     * @return PasswordReset|null
     */
    public function findByPasswordResetToken($token);
}
