<?php

namespace SumoCoders\FrameworkMultiUserBundle\Security;

use SumoCoders\FrameworkMultiUserBundle\Exception\InvalidPasswordResetTokenException;
use SumoCoders\FrameworkMultiUserBundle\User\UserInterface;

class PasswordResetToken
{
    private static function generatePasswordResetToken()
    {
        return time() . base64_encode(random_bytes(10));
    }

    public static function validateToken(UserInterface $user, $token)
    {
        if ($user->getPasswordResetToken() === $token) {
            return true;
        }

        throw new InvalidPasswordResetTokenException('The given token is not valid.');
    }

    public static function generate()
    {
        return self::generatePasswordResetToken();
    }
}
