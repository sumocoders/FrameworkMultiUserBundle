<?php

namespace SumoCoders\FrameworkMultiUserBundle\Event;

use SumoCoders\FrameworkMultiUserBundle\User\PasswordReset;
use Symfony\Component\EventDispatcher\Event;

class PasswordResetTokenCreated extends Event
{
    const NAME = 'multi_user.event.password_reset_token_created';

    /**
     * @var PasswordReset
     */
    private $user;

    /**
     * PasswordResetTokenCreated constructor.
     *
     * @param PasswordReset $user
     */
    public function __construct(PasswordReset $user)
    {
        $this->user = $user;
    }

    /**
     * @return PasswordReset
     */
    public function getUser()
    {
        return $this->user;
    }
}
