<?php

namespace SumoCoders\FrameworkMultiUserBundle\Controller;

use SumoCoders\FrameworkMultiUserBundle\Command\PasswordReset;
use SumoCoders\FrameworkMultiUserBundle\Command\PasswordResetHandler;
use SumoCoders\FrameworkMultiUserBundle\Exception\InvalidPasswordConfirmationException;
use SumoCoders\FrameworkMultiUserBundle\Form\ChangePassword;
use SumoCoders\FrameworkMultiUserBundle\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class PasswordResetController extends Controller
{
    /**
     * @param Request $request
     *
     * @throws InvalidPasswordConfirmationException
     *
     * @return array|RedirectResponse
     */
    public function resetAction(Request $request)
    {
        $userReposioryCollection = $this->container->get('multi_user.user_repository.collection');
        $user = $userReposioryCollection->findUserByToken($request->get('token'));

        $changePassword = new ChangePassword();
        $form = $this->createForm(ChangePasswordType::class, $changePassword);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new PasswordReset($user, $changePassword->getNewPassword(), $changePassword->getNewPassword());
            $handler = new PasswordResetHandler($userReposioryCollection);
            $handler->handle($command);

            return $this->redirectToRoute('multi_user_login');
        }

        return
            [
                'form' => $form->createView(),
            ];
    }
}
