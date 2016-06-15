<?php

namespace SumoCoders\FrameworkMultiUserBundle\Event;

use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Translation\TranslatorInterface;

class OnPasswordResetTokenCreated
{
    private $mailer;

    private $translator;

    private $emailFrom;

    private $twig;

    public function __construct(EventDispatcherInterface $dispatcher, Swift_Mailer $mailer, TranslatorInterface $translator, TwigEngine $twig, $emailFrom)
    {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->emailFrom = $emailFrom;
        $this->twig = $twig;
        
        $dispatcher->addListener(PasswordResetTokenCreated::NAME, [$this, 'onPasswordResetTokenCreated']);
    }

    public function onPasswordResetTokenCreated(PasswordResetTokenCreated $event)
    {
        $message = Swift_Message::newInstance()
            ->setSubject('Password reset requested')
            ->setFrom($this->emailFrom)
            ->setTo($event->getUser()->getEmail())
            ->setBody(
                $this->twig->render(
                    'SumoCodersFrameworkMultiUserBundle:Email:passwordReset.html.twig',
                    ['user' => $event->getUser()]
                ),
                'text/html'
            );

        return $this->mailer->send($message);
    }
}
