<?php

namespace SumoCoders\FrameworkMultiUserBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FormAuthenticator extends AbstractFormLoginAuthenticator
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /** RouterInterface */
    private $router;

    /** array */
    private $redirectRoutes = [];

    /**
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param RouterInterface $router
     * @param array $redirectRoutes
     */
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        RouterInterface $router,
        array $redirectRoutes = []
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->router = $router;
        $this->redirectRoutes = $redirectRoutes;
    }

    /**
     * {@inheritdoc}
     *
     * @return FormCredentials
     */
    public function getCredentials(Request $request)
    {
        if ($request->getPathInfo() !== $this->getLoginUrl()
            || !$request->isMethod(Request::METHOD_POST)) {
            return;
        }

        return new FormCredentials(
            $request->request->get('_username'),
            $request->request->get('_password')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials->getUsername());
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $plainPassword = $credentials->getPlainPassword();
        $encoder = $this->passwordEncoder;

        if (!$encoder->isPasswordValid($user, $plainPassword)) {
            throw new BadCredentialsException();
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function getLoginUrl()
    {
        return $this->router->generate('multi_user_login');
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // if the user hit a secure page and start() was called, this was
        // the URL they were on, and probably where you want to redirect to
        $targetPath = $request->getSession()->get('_security.'.$providerKey.'.target_path');

        if (!$targetPath) {
            $targetPath = $this->getSuccessRedirectUrl($token);
        }

        return new RedirectResponse($targetPath);
    }

    public function getSuccessRedirectUrl(TokenInterface $token)
    {
        foreach ($this->redirectRoutes as $class => $route) {
            if (get_class($token->getUser()) === $class) {
                return $this->router->generate($route['route']);
            }
        }

        return $this->getDefaultSuccessRedirectURL();
    }

    protected function getDefaultSuccessRedirectURL()
    {
        return '/';
    }
}
