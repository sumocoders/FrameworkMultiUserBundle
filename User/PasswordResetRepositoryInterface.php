<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

interface PasswordResetRepositoryInterface
{
    /**
     * @param string $token
     * @return UserInterface|null
     */
    public function findByPasswordResetToken($token);
}
