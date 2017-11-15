<?php

namespace SumoCoders\FrameworkMultiUserBundle\User\Interfaces;

use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;

interface PasswordReset
{
    public function getEmail(): string;

    public function getPasswordResetToken(): ?PasswordResetToken;

    public function setPassword(string $password);

    public function generatePasswordResetToken();

    public function clearPasswordResetToken();
}
