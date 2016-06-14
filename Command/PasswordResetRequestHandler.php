<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\PasswordResetInterface;
use SumoCoders\FrameworkMultiUserBundle\User\UserInterface;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Swift_Mailer;
use Swift_Message;

class PasswordResetRequestHandler
{
    /**
     * @var UserRepositoryCollection
     */
    private $userRepositoryCollection;

    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $bodyText;

    public function __construct(UserRepositoryCollection $userRepositoryCollection, Swift_Mailer $mailer, $bodyText)
    {
        $this->userRepositoryCollection = $userRepositoryCollection;
        $this->mailer = $mailer;
    }

    /**
     * Creates a password reset token and sends an email to the user.
     *
     * @param PasswordResetRequest $command
     */
    public function handle(PasswordResetRequest $command)
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
     * @param PasswordResetInterface $user
     *
     * @return int
     */
    private function sendPasswordResetToken(PasswordResetInterface $user) {
        $messageBody = $this->getPasswordResetMessage($user);

        $message = Swift_Message::newInstance()
            ->setSubject('Password reset requested')
            ->setFrom('send@example.com')
            ->setTo($user->getEmail())
            ->setBody( $messageBody, 'text/plain');
        
        return $this->mailer->send($message);
    }

    /**
     * Creates the password reset message.
     *
     * @param PasswordResetInterface $user
     *
     * @return string
     */
    private function getPasswordResetMessage(PasswordResetInterface $user)
    {
        return str_replace('%token%', $user->getPasswordResetToken(), $this->bodyText);
    }
}