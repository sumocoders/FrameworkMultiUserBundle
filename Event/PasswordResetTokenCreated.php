<?php

namespace SumoCoders\FrameworkMultiUserBundle\Event;

use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserWithPassword;
use Symfony\Component\EventDispatcher\Event;

class PasswordResetTokenCreated extends Event
{
    const NAME = 'multi_user.event.password_reset_token_created';

    /**
     * @var UserWithPassword
     */
    private $user;

    /**
     * PasswordResetTokenCreated constructor.
     *
     * @param UserWithPassword $user
     */
    public function __construct(UserWithPassword $user)
    {
        $this->user = $user;
    }

    /**
     * @return UserWithPassword
     */
    public function getUser()
    {
        return $this->user;
    }
}
