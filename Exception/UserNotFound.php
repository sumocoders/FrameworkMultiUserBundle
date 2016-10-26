<?php

namespace SumoCoders\FrameworkMultiUserBundle\Exception;

use Exception;
use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;

final class UserNotFound extends Exception
{
    /**
     * @param string $username
     *
     * @return self
     */
    public static function withUsername($username)
    {
        return new self('No user found with username "' . $username . '".');
    }

    /**
     * @param PasswordResetToken $token
     *
     * @return self
     */
    public static function withToken(PasswordResetToken $token)
    {
        return new self('No user found with password reset token "' . $token->getToken() . '".');
    }
}
