<?php

namespace SumoCoders\FrameworkMultiUserBundle\Controller;

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
     * @param EngineInterface $templating
     * @param AuthenticationUtils $authenticationUtils
     */
    public function __construct(
        EngineInterface $templating,
        AuthenticationUtils $authenticationUtils
    ) {
        $this->templating = $templating;
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @param Request $request
     */
    public function loginAction(Request $request)
    {
        $exception = $this->authenticationUtils->getLastAuthenticationError();

        return $this->templating->renderResponse(
            'SumoCodersFrameworkMultiUserBundle:Login:login.html.twig',
            [
                'error' => $exception ? $exception->getMessage() : null,
            ]
        );
    }
}
