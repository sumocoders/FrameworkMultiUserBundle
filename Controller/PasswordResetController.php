<?php

namespace SumoCoders\FrameworkMultiUserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SumoCoders\FrameworkMultiUserBundle\Command\ResetPassword;
use SumoCoders\FrameworkMultiUserBundle\Command\RequestPasswordReset;
use SumoCoders\FrameworkMultiUserBundle\Exception\InvalidPasswordConfirmationException;
use SumoCoders\FrameworkMultiUserBundle\Form\ChangePassword;
use SumoCoders\FrameworkMultiUserBundle\Form\ChangePasswordType;
use SumoCoders\FrameworkMultiUserBundle\Form\RequestPassword;
use SumoCoders\FrameworkMultiUserBundle\Form\RequestPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class PasswordResetController extends Controller
{
    /**
     * @param Request $request
     *
     * @Template()
     *
     * @return array
     */
    public function requestAction(Request $request)
    {
        $userReposioryCollection = $this->container->get('multi_user.user_repository.collection');
        $requestPassword = new RequestPassword($userReposioryCollection);
        $form = $this->createForm(RequestPasswordType::class, $requestPassword);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new RequestPasswordReset($requestPassword->getUser());
            $handler = $this->container->get('multi_user.handler.request_password');
            $handler->handle($command);
        }

        return [ 'form' => $form->createView(), ];
    }

    /**
     * @param Request $request
     *
     * @Template()
     *
     * @throws InvalidPasswordConfirmationException
     *
     * @return array|RedirectResponse
     */
    public function resetAction(Request $request, $token)
    {
        $userReposioryCollection = $this->container->get('multi_user.user_repository.collection');
        $user = $userReposioryCollection->findUserByToken($token);

        $changePassword = new ChangePassword();
        $form = $this->createForm(ChangePasswordType::class, $changePassword);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new ResetPassword($user, $changePassword->newPassword, $changePassword->newPassword);
            $handler = $this->container->get('multi_user.handler.reset_password');
            $handler->handle($command);

            return $this->redirectToRoute('multi_user_login');
        }

        return
            [
                'form' => $form->createView(),
            ];
    }
}
