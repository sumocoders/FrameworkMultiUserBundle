<?php

namespace SumoCoders\FrameworkMultiUserBundle\Controller;

use SumoCoders\FrameworkMultiUserBundle\Command\ResetPasswordHandler;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\ChangePasswordDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\Exception\InvalidPasswordConfirmationException;
use SumoCoders\FrameworkMultiUserBundle\Form\ChangePasswordType;
use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class PasswordResetController
{
    /** @var UserRepositoryCollection */
    private $userRepositoryCollection;

    /** @var ResetPasswordHandler */
    private $resetPasswordHandler;

    /** @var Router */
    private $router;

    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var EngineInterface */
    private $templating;

    /**
     * @param UserRepositoryCollection $userRepositoryCollection
     * @param ResetPasswordHandler $resetPasswordHandler
     * @param Router $router
     * @param FormFactoryInterface $formFactory
     * @param EngineInterface $templating
     */
    public function __construct(
        UserRepositoryCollection $userRepositoryCollection,
        ResetPasswordHandler $resetPasswordHandler,
        Router $router,
        FormFactoryInterface $formFactory,
        EngineInterface $templating
    ) {
        $this->userRepositoryCollection = $userRepositoryCollection;
        $this->resetPasswordHandler = $resetPasswordHandler;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->templating = $templating;
    }

    /**
     * @param Request $request
     * @param PasswordResetToken $token
     *
     * @throws InvalidPasswordConfirmationException
     *
     * @return RedirectResponse
     */
    public function resetAction(Request $request, PasswordResetToken $token)
    {
        $user = $this->userRepositoryCollection->findUserByToken($token);

        if ($user === null) {
            return new RedirectResponse(
                $this->router->generate('multi_user_login')
            );
        }

        $changePasswordTransferObject = ChangePasswordDataTransferObject::forUser($user);
        $form = $this->formFactory->create(ChangePasswordType::class, $changePasswordTransferObject);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resetPasswordHandler->handle($form->getData());

            return new RedirectResponse(
                $this->router->generate('multi_user_login')
            );
        }

        return $this->templating->renderResponse(
            'SumoCodersFrameworkMultiUserBundle:PasswordReset:reset.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
