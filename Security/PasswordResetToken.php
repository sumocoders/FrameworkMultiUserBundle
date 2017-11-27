<?php

namespace SumoCoders\FrameworkMultiUserBundle\Security;

use SumoCoders\FrameworkMultiUserBundle\Exception\InvalidPasswordResetTokenException;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;

class PasswordResetToken
{
    /** @var string */
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param User $user
     * @param PasswordResetToken $token
     *
     * @throws InvalidPasswordResetTokenException
     *
     * @return bool
     */
    public static function validateToken(User $user, PasswordResetToken $token): bool
    {
        if ($user->getPasswordResetToken()->equals($token)) {
            return true;
        }

        throw new InvalidPasswordResetTokenException('The given token is not valid.');
    }

    public static function generate(): PasswordResetToken
    {
        return new self(uniqid());
    }

    public function equals(PasswordResetToken $token): bool
    {
        return $token->token === $this->token;
    }

    public function __toString(): string
    {
        return $this->getToken();
    }
}
