<?php

namespace SumoCoders\FrameworkMultiUserBundle\Event;

use SumoCoders\FrameworkCoreBundle\Mail\MessageFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Swift_Mailer;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

class OnPasswordResetTokenCreated implements EventSubscriberInterface
{
    /** @var MessageFactory */
    private $messageFactory;

    /** @var Swift_Mailer */
    private $mailer;

    /** @var TranslatorInterface */
    private $translator;

    /** @var string */
    private $emailFrom;

    /** @var EngineInterface */
    private $engine;

    public function __construct(
        MessageFactory $messageFactory,
        Swift_Mailer $mailer,
        TranslatorInterface $translator,
        EngineInterface $engine,
        $emailFrom
    ) {
        $this->messageFactory = $messageFactory;
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->engine = $engine;
        $this->emailFrom = $emailFrom;
    }

    /**
     * @param PasswordResetTokenCreated $event
     *
     * @return int
     */
    public function onPasswordResetTokenCreated(PasswordResetTokenCreated $event)
    {
        $message = $this->messageFactory->createHtmlMessage(
            'Password reset requested',
            $this->engine->render(
                'SumoCodersFrameworkMultiUserBundle:Email:passwordReset.html.twig',
                ['user' => $event->getUser()]
            )
        );

        $message
            ->setFrom($this->emailFrom)
            ->setTo($event->getUser()->getEmail())
        ;

        return $this->mailer->send($message);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            PasswordResetTokenCreated::NAME => [
                ['onPasswordResetTokenCreated', 0],
            ],
        ];
    }
}
