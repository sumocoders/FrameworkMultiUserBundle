<?php

namespace SumoCoders\FrameworkMultiUserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SumoCoders\FrameworkCoreBundle\BreadCrumb\BreadCrumbBuilder;
use SumoCoders\FrameworkMultiUserBundle\Command\Handler;
use SumoCoders\FrameworkMultiUserBundle\Form\DeleteType;
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

    /** @var string */
    private $form;

    /** @var UserRepository */
    private $userRepository;

    /** @var BreadCrumbBuilder */
    private $breadcrumbBuilder;

    /** @var array */
    private $breadcrumbs;

    /** @var string */
    private $redirectRoute;

    public function __construct(
        FormFactoryInterface $formFactory,
        Router $router,
        FlashBagInterface $flashBag,
        TranslatorInterface $translator,
        string $form,
        Handler $handler,
        UserRepository $userRepository,
        string $redirectRoute = null
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
     * @param int|null $id
     *
     * @Template()
     *
     * @return array|RedirectResponse
     */
    public function baseAction(Request $request, int $id = null)
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

        if ($id !== null) {
            $deleteForm = $this->formFactory->create(DeleteType::class, $form->getData());

            return [
                'form' => $form->createView(),
                'deleteForm' => $deleteForm->createView(),
                'user' => $form->getData()->getEntity(),
            ];
        }

        return ['form' => $form->createView()];
    }

    private function getFormForId(?int $id = null): Form
    {
        if ($id === null) {
            return $this->formFactory->create($this->form);
        }

        $user = $this->userRepository->find((int) $id);
        $dataTransferObjectClass = $this->form::getDataTransferObjectClass();
        $dataTransferObject = $dataTransferObjectClass::fromUser($user);

        return $this->formFactory->create($this->form, $dataTransferObject);
    }
}
