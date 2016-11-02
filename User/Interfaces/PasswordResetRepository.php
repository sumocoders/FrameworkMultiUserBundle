<?php

namespace SumoCoders\FrameworkMultiUserBundle\User\Interfaces;

use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;

interface PasswordResetRepository
{
    /**
     * @param PasswordResetToken $token
     *
     * @return User|null
     */
    public function findByPasswordResetToken(PasswordResetToken $token);
}
