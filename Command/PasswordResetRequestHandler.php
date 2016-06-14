<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\PasswordResetInterface;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

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
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(UserRepositoryCollection $userRepositoryCollection, Swift_Mailer $mailer, TranslatorInterface $translator, RouterInterface $router)
    {
        $this->userRepositoryCollection = $userRepositoryCollection;
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->router = $router;
    }

    /**
     * Creates a password reset token and sends an email to the user.
     *
     * @param PasswordResetRequest $command
     *
     * @return int
     */
    public function handle(PasswordResetRequest $command)
    {
        $user = $command->getUser();
        $user->generatePasswordResetToken();
        $repository = $this->userRepositoryCollection->findRepositoryByClassName(get_class($user));
        $repository->save($user);

        return $this->sendPasswordResetToken($user);
    }

    /**
     * Sends the password reset token to the user.
     *
     * @param PasswordResetInterface $user
     *
     * @return int
     */
    private function sendPasswordResetToken(PasswordResetInterface $user)
    {
        $messageBody = $this->getPasswordResetMessage($user);

        $message = Swift_Message::newInstance()
            ->setSubject('Password reset requested')
            ->setFrom('send@example.com')
            ->setTo($user->getEmail())
            ->setBody($messageBody, 'text/plain');

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
        $url = $this->router->generate('multi_user_reset_password', [], true);
        $token = '?token='.urlencode($user->getPasswordResetToken());

        return $this->translator->trans('sumocoders.multiuserbundle.mail.request_password', ['%link%' => $url.$token]);
    }
}
