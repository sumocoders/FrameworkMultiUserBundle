<?php

namespace SumoCoders\FrameworkMultiUserBundle\Event;

use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Translation\TranslatorInterface;

class OnPasswordResetTokenCreated
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var string
     */
    private $emailFrom;

    /**
     * @var TwigEngine
     */
    private $twig;

    /**
     * OnPasswordResetTokenCreated constructor.
     *
     * @param Swift_Mailer $mailer
     * @param TranslatorInterface $translator
     * @param TwigEngine $twig
     * @param $emailFrom
     */
    public function __construct(
        Swift_Mailer $mailer,
        TranslatorInterface $translator,
        TwigEngine $twig,
        $emailFrom
    ) {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->emailFrom = $emailFrom;
        $this->twig = $twig;
    }

    /**
     * @param PasswordResetTokenCreated $event
     *
     * @return int
     *
     * @throws \Twig_Error
     */
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
