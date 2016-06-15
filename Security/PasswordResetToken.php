<?php

namespace SumoCoders\FrameworkMultiUserBundle\Security;

use SumoCoders\FrameworkMultiUserBundle\Exception\InvalidPasswordResetTokenException;
use SumoCoders\FrameworkMultiUserBundle\User\UserInterface;

class PasswordResetToken
{
    /**
     * @var string
     */
    private $token;

    /**
     * PasswordResetToken constructor.
     *
     * @param string|null $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param UserInterface $user
     * @param $token
     *
     * @throws InvalidPasswordResetTokenException
     *
     * @return bool
     */
    public static function validateToken(UserInterface $user, PasswordResetToken $token)
    {
        if ($user->getPasswordResetToken()->equals($token)) {
            return true;
        }

        throw new InvalidPasswordResetTokenException('The given token is not valid.');
    }

    /**
     * Generates a PasswordToken
     *
     * @return PasswordResetToken
     */
    public static function generate()
    {
        $token = time() . base64_encode(random_bytes(10));

        return new self($token);
    }
}
