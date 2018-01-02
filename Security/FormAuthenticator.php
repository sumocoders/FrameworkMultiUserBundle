<?php

namespace SumoCoders\FrameworkMultiUserBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Translation\TranslatorInterface;

class FormAuthenticator extends AbstractFormLoginAuthenticator
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /** @var RouterInterface */
    private $router;

    /** @var FlashBagInterface */
    private $flashBag;

    /** @var TranslatorInterface */
    private $translator;

    /** array */
    private $redirectRoutes = [];

    /**
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param RouterInterface $router
     * @param FlashBagInterface $flashBag
     * @param TranslatorInterface $translator
     * @param array $redirectRoutes
     */
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        RouterInterface $router,
        FlashBagInterface $flashBag,
        TranslatorInterface $translator,
        array $redirectRoutes = []
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->router = $router;
        $this->flashBag = $flashBag;
        $this->translator = $translator;
        $this->redirectRoutes = $redirectRoutes;
    }

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

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials->getUsername());
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $plainPassword = $credentials->getPlainPassword();
        $encoder = $this->passwordEncoder;

        if (!$encoder->isPasswordValid($user, $plainPassword)) {
            throw new BadCredentialsException();
        }

        return true;
    }

    public function supports(Request $request)
    {
        return $request->getBasePath() === '/login' && $request->isMethod('POST');
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('multi_user_login');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // if the user hit a secure page and start() was called, this was
        // the URL they were on, and probably where you want to redirect to
        $targetPath = $request->getSession()->get('_security.'.$providerKey.'.target_path');

        if (!$targetPath) {
            $targetPath = $this->getSuccessRedirectUrl($token);
        }

        $this->flashBag->add(
            'success',
            $this->translator->trans(
                'sumocoders.multiuserbundle.flash.login_success',
                [
                    '%username%' => $token->getUsername(),
                ]
            )
        );

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
