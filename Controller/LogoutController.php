<?php

namespace SumoCoders\FrameworkMultiUserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\SecurityContext;

final class LogoutController
{
    private $securityContext;
    private $router;

    /**
     * LogoutController constructor.
     *
     * @param SecurityContext $securityContext
     * @param Router $router
     */
    public function __construct(SecurityContext $securityContext, Router $router)
    {
        $this->securityContext = $securityContext;
        $this->router = $router;
    }

    /**
     * Logout user.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function logoutAction(Request $request)
    {
        $this->securityContext->setToken(null);
        $request->getSession()->invalidate();

        return new RedirectResponse($this->router->generate('login'));
    }
}
