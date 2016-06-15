<?php

namespace SumoCoders\FrameworkMultiUserBundle\Event;

use Swift_Mailer;
use Swift_Message;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Translation\TranslatorInterface;

class OnPasswordResetTokenCreated
{
    private $mailer;

    private $translator;

    private $emailFrom;

    public function __construct(EventDispatcherInterface $dispatcher, Swift_Mailer $mailer, TranslatorInterface $translator, $emailFrom)
    {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->emailFrom = $emailFrom;
        
        $dispatcher->addListener(PasswordResetTokenCreated::NAME, [$this, 'onPasswordResetTokenCreated']);
    }

    public function onPasswordResetTokenCreated(PasswordResetTokenCreated $event)
    {
        $message = Swift_Message::newInstance()
            ->setSubject('Password reset requested')
            ->setFrom($this->emailFrom)
            ->setTo($event->getUser()->getEmail())
            ->setBody('', 'text/plain');

        return $this->mailer->send($message);
    }
}
