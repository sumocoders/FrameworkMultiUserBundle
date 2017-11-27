<?php

namespace SumoCoders\FrameworkMultiUserBundle\Exception;

use Exception;
use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;

final class UserNotFound extends Exception
{
    public static function withUsername(string $username): self
    {
        return new self('No user found with username "' . $username . '".');
    }

    public static function withToken(PasswordResetToken $token): self
    {
        return new self('No user found with password reset token "' . $token->getToken() . '".');
    }
}
