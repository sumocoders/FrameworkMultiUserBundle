<?php

namespace SumoCoders\FrameworkMultiUserBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Routing\RouterInterface;

class FormAuthenticator extends AbstractFormLoginAuthenticator
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /** RouterInterface */
    private $router;

    /**
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param RouterInterface $router
     */
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        RouterInterface $router
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->router = $router;
    }

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials->getUsername());
    }

    /**
     * {@inheritDoc}
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

    protected function getLoginUrl()
    {
        return $this->router->generate('multi_user_login');
    }

    protected function getDefaultSuccessRedirectURL()
    {
        return '/en/success';
    }
}
