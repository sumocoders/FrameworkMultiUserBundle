<?php

namespace SumoCoders\FrameworkMultiUserBundle\Controller;

use SumoCoders\FrameworkMultiUserBundle\Security\FormAuthenticator;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController
{
    /** @var EngineInterface */
    private $templating;

    /** @var AuthenticationUtils */
    private $authenticationUtils;

    /** @var FormAuthenticator */
    private $formAuthenticator;

    /** @var TokenStorage */
    private $tokenStorage;

    /** @var Translator */
    private $translator;

    public function __construct(
        EngineInterface $templating,
        AuthenticationUtils $authenticationUtils,
        FormAuthenticator $formAuthenticator,
        TokenStorage $tokenStorage,
        Translator $translator
    ) {
        $this->templating = $templating;
        $this->authenticationUtils = $authenticationUtils;
        $this->formAuthenticator = $formAuthenticator;
        $this->tokenStorage = $tokenStorage;
        $this->translator = $translator;
    }

    public function loginAction(): Response
    {
        if ($this->tokenStorage->getToken()->getUser() instanceof User) {
            return new RedirectResponse(
                $this->formAuthenticator->getSuccessRedirectUrl($this->tokenStorage->getToken())
            );
        }

        $exception = $this->authenticationUtils->getLastAuthenticationError();

        return $this->templating->renderResponse(
            'SumoCodersFrameworkMultiUserBundle:Login:login.html.twig',
            [
                'error' => $this->getTranslatedErrorMessageFromAuthenticationException($exception),
            ]
        );
    }

    private function getTranslatedErrorMessageFromAuthenticationException(
        ?AuthenticationException $exception = null
    ): ?string {
        if ($exception === null) {
            return null;
        }

        switch (true) {
            case $exception instanceof UsernameNotFoundException:
                return $this->translateValidatorMessage('sumocoders.multiuserbundle.login.username_not_found');
            case $exception instanceof BadCredentialsException:
                return $this->translateValidatorMessage('sumocoders.multiuserbundle.login.bad_credentials');
            case $exception instanceof UnsupportedUserException:
                return $this->translateValidatorMessage('sumocoders.multiuserbundle.login.unsupported_user');
            default:
                return $this->translateValidatorMessage('sumocoders.multiuserbundle.something_went_wrong');
        }
    }

    private function translateValidatorMessage(string $messageString): string
    {
        return $this->translator->trans(
            $messageString,
            [],
            'validators'
        );
    }
}
