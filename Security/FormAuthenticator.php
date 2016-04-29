<?php

namespace SumoCoders\FrameworkMultiUserBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class FormAuthenticator extends AbstractFormLoginAuthenticator
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordDecoder;

    /**
     * @param UserPasswordEncoderInterface $passwordDecoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordDecoder)
    {
        $this->passwordDecoder = $passwordDecoder;
    }

    /**
     * {@inheritDoc}
     *
     * @return FormCredentials
     */
    public function getCredentials(Request $request)
    {
        // @todo: there will probably be a better way te determine if the login
        // form has been submitted
        if (!$request->request->has('_username')
            || !$request->request->has('_password')) {
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
    }

    protected function getLoginUrl()
    {
        return '/login';
    }

    protected function getDefaultSuccessRedirectURL()
    {
        return '/success';
    }
}
