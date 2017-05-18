<?php

namespace SumoCoders\FrameworkMultiUserBundle\Controller;

use SumoCoders\FrameworkMultiUserBundle\Command\RequestPasswordResetHandler;
use SumoCoders\FrameworkMultiUserBundle\Exception\UserNotFound;
use SumoCoders\FrameworkMultiUserBundle\Form\RequestPasswordType;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

final class RequestPasswordResetController
{
    /** @var EngineInterface */
    private $templating;

    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var RequestPasswordResetHandler */
    private $requestPasswordResetHandler;

    /** @var Router */
    private $router;

    /** @var Translator */
    private $translator;

    /** @var FlashBagInterface */
    private $flashBag;

    /**
     * @param EngineInterface $templating
     * @param FormFactoryInterface $formFactory
     * @param RequestPasswordResetHandler $requestPasswordResetHandler
     * @param Router $router
     * @param Translator $translator
     * @param FlashBagInterface $flashBag
     */
    public function __construct(
        EngineInterface $templating,
        FormFactoryInterface $formFactory,
        RequestPasswordResetHandler $requestPasswordResetHandler,
        Router $router,
        Translator $translator,
        FlashBagInterface $flashBag
    ) {
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->requestPasswordResetHandler = $requestPasswordResetHandler;
        $this->router = $router;
        $this->translator = $translator;
        $this->flashBag = $flashBag;
    }

    /**
     * @param Request $request
     *
     * @return array|RedirectResponse|Response
     */
    public function requestAction(Request $request)
    {
        $form = $this->formFactory->create(RequestPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->requestPasswordResetHandler->handle($form->getData());
            } catch (UserNotFound $ignore) {
            }

            $this->flashBag->add(
                'success',
                $this->translator->trans(
                    'sumocoders.multiuserbundle.flash.password_reset_request_success'
                )
            );

            return new RedirectResponse($this->router->generate('multi_user_login'));
        }

        return $this->templating->renderResponse(
            'SumoCodersFrameworkMultiUserBundle:PasswordReset:request.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
