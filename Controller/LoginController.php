<?php

namespace SumoCoders\FrameworkMultiUserBundle\Controller;

use SumoCoders\FrameworkMultiUserBundle\Security\FormAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController
{
    /** @var EntineInterface */
    private $templating;

    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;

    /**
     * @var FormAuthenticator
     */
    private $formAuthenticator;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * @param EngineInterface $templating
     * @param AuthenticationUtils $authenticationUtils
     * @param FormAuthenticator $formAuthenticator
     * @param TokenStorage $tokenStorage
     */
    public function __construct(
        EngineInterface $templating,
        AuthenticationUtils $authenticationUtils,
        FormAuthenticator $formAuthenticator,
        TokenStorage $tokenStorage
    ) {
        $this->templating = $templating;
        $this->authenticationUtils = $authenticationUtils;
        $this->formAuthenticator = $formAuthenticator;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param Request $request
     */
    public function loginAction(Request $request)
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
                'error' => $exception ? $exception->getMessage() : null,
            ]
        );
    }
}
