<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

interface PasswordResetRepository
{
    /**
     * @param string $token
     *
     * @return UserInterface|null
     */
    public function findByPasswordResetToken($token);
}
