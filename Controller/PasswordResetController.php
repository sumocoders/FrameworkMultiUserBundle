<?php

namespace SumoCoders\FrameworkMultiUserBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\ChangePasswordDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\Exception\InvalidPasswordConfirmationException;
use SumoCoders\FrameworkMultiUserBundle\Form\ChangePasswordType;
use SumoCoders\FrameworkMultiUserBundle\Form\RequestPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
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
        $form = $this->createForm(RequestPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $handler = $this->container->get('multi_user.handler.request_password');
            try {
                $handler->handle($form->getData());

                return $this->redirectToRoute('multi_user_login');
            } catch (EntityNotFoundException $exception) {
                $errorMessage = ucfirst($this->get('translator')->trans(
                    'sumocoders.multiuserbundle.form.user_not_found',
                    ['%username%' => $form->getData()->userName]
                ));
                $form->addError(new FormError($errorMessage));

                return ['form' => $form->createView()];
            }
        }

        return ['form' => $form->createView()];
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

        if ($user === null) {
            return $this->redirectToRoute('multi_user_login');
        }

        $changePasswordTransferObject = ChangePasswordDataTransferObject::forUser($user);
        $form = $this->createForm(ChangePasswordType::class, $changePasswordTransferObject);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $handler = $this->container->get('multi_user.handler.reset_password');
            $handler->handle($form->getData());

            return $this->redirectToRoute('multi_user_login');
        }

        return
            [
                'form' => $form->createView(),
            ];
    }
}
