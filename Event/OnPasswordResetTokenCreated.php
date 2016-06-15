<?php

namespace SumoCoders\FrameworkMultiUserBundle\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

class OnPasswordResetTokenCreated implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            PasswordResetTokenCreated::NAME => [
                ['onPasswordResetTokenCreated', 0],
            ],
        ];
    }
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
     * @var EngineInterface
     */
    private $engine;

    /**
     * OnPasswordResetTokenCreated constructor.
     *
     * @param Swift_Mailer $mailer
     * @param TranslatorInterface $translator
     * @param EngineInterface $engine
     * @param $emailFrom
     */
    public function __construct(
        Swift_Mailer $mailer,
        TranslatorInterface $translator,
        EngineInterface $engine,
        $emailFrom
    ) {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->emailFrom = $emailFrom;
        $this->engine = $engine;
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
                $this->engine->render(
                    'SumoCodersFrameworkMultiUserBundle:Email:passwordReset.html.twig',
                    ['user' => $event->getUser()]
                ),
                'text/html'
            );

        return $this->mailer->send($message);
    }
}
