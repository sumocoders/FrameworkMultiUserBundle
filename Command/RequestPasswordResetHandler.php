<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\Event\PasswordResetTokenCreated;
use SumoCoders\FrameworkMultiUserBundle\User\PasswordReset as UserPasswordReset;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Swift_Mailer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RequestPasswordResetHandler
{
    /**
     * @var UserRepositoryCollection
     */
    private $userRepositoryCollection;

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * PasswordResetRequestHandler constructor.
     *
     * @param UserRepositoryCollection $userRepositoryCollection
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        UserRepositoryCollection $userRepositoryCollection,
        EventDispatcherInterface $dispatcher
    ) {
        $this->userRepositoryCollection = $userRepositoryCollection;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Creates a password reset token and sends an email to the user.
     *
     * @param RequestPasswordReset $command
     *
     * @return int
     */
    public function handle(RequestPasswordReset $command)
    {
        $user = $command->getUser();
        $user->generatePasswordResetToken();
        $repository = $this->userRepositoryCollection->findRepositoryByClassName(get_class($user));
        $repository->save($user);

        $this->sendPasswordResetToken($user);
    }

    /**
     * Sends the password reset token to the user.
     *
     * @param UserPasswordReset $user
     *
     * @return int
     */
    private function sendPasswordResetToken(UserPasswordReset $user)
    {
        $event = new PasswordResetTokenCreated($user);
        $this->dispatcher->dispatch('multi_user.event.password_reset_token_created', $event);
    }
}
