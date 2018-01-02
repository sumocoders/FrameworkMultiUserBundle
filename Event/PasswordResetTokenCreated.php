<?php

namespace SumoCoders\FrameworkMultiUserBundle\Event;

use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;
use Symfony\Component\EventDispatcher\Event;

class PasswordResetTokenCreated extends Event
{
    const NAME = 'multi_user.event.password_reset_token_created';

    /** @var User */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
