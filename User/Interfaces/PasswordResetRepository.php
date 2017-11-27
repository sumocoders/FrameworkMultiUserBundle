<?php

namespace SumoCoders\FrameworkMultiUserBundle\User\Interfaces;

use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;

interface PasswordResetRepository
{
    public function findByPasswordResetToken(PasswordResetToken $token): ?User;
}
