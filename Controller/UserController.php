<?php

namespace SumoCoders\FrameworkMultiUserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SumoCoders\FrameworkMultiUserBundle\Command\Handler;
use SumoCoders\FrameworkMultiUserBundle\Form\Interfaces\FormWithDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * This class handles all the user actions.
 * Register a service for each action.
 */
class UserController
{
    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var Router */
    private $router;

    /** @var FlashBagInterface */
    private $flashBag;

    /** @var TranslatorInterface */
    private $translator;

    /** @var Handler */
    private $handler;

    /** @var FormWithDataTransferObject */
    private $form;

    /** @var UserRepository */
    private $userRepository;

    /** @var string */
    private $redirectRoute;

    /**
     * @param FormFactoryInterface $formFactory
     * @param Router $router
     * @param FlashBagInterface $flashBag
     * @param TranslatorInterface $translator
     * @param FormWithDataTransferObject $form
     * @param Handler $handler
     * @param UserRepository $userRepository
     * @param string $redirectRoute = null
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        Router $router,
        FlashBagInterface $flashBag,
        TranslatorInterface $translator,
        FormWithDataTransferObject $form,
        Handler $handler,
        UserRepository $userRepository,
        $redirectRoute = null
    ) {
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->flashBag = $flashBag;
        $this->translator = $translator;
        $this->form = $form;
        $this->handler = $handler;
        $this->userRepository = $userRepository;
        $this->redirectRoute = $redirectRoute;
    }

    /**
     * @param Request $request
     * @param int $id
     *
     * @Template()
     *
     * @return array
     */
    public function baseAction(Request $request, $id = null)
    {
        $form = $this->getFormForId($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = $form->getData();
            $this->handler->handle($command);

            $this->flashBag->add(
                'success',
                $this->translator->trans(
                    $id === null ? 'sumocoders.multiuserbundle.flash.added' : 'sumocoders.multiuserbundle.flash.edited',
                    ['%user%' => $command->getEntity()->getDisplayName()]
                )
            );

            if ($this->redirectRoute !== null) {
                return new RedirectResponse($this->router->generate($this->redirectRoute));
            }
        }

        return ['form' => $form->createView()];
    }

    /**
     * @param int $id = null
     *
     * @return Form
     */
    private function getFormForId($id = null)
    {
        if ($id === null) {
            return $this->formFactory->create($this->form);
        }

        $user = $this->userRepository->find((int) $id);
        $dataTransferObjectClass = $this->form->getDataTransferObjectClass();
        $dataTransferObject = $dataTransferObjectClass::fromUser($user);

        return $this->formFactory->create($this->form, $dataTransferObject);
    }
}
