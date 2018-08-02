<?php

namespace SumoCoders\FrameworkMultiUserBundle\Controller;

use SumoCoders\FrameworkMultiUserBundle\Command\Handler;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces\UserDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\Form\DeleteType;
use SumoCoders\FrameworkMultiUserBundle\Form\Interfaces\FormWithDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * This class handles all the user actions.
 * Register a service for each action.
 */
class UserController
{
    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var Router */
    protected $router;

    /** @var FlashBagInterface */
    protected $flashBag;

    /** @var TranslatorInterface */
    protected $translator;

    /** @var Handler */
    protected $handler;

    /** @var string */
    protected $form;

    /** @var UserRepository */
    protected $userRepository;

    /** @var string */
    protected $redirectRoute;

    /** @var EngineInterface */
    private $engine;

    public function __construct(
        EngineInterface $engine,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        FlashBagInterface $flashBag,
        TranslatorInterface $translator,
        FormWithDataTransferObject $form,
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
        $this->engine = $engine;
    }

    /**
     * @param Request $request
     * @param int|null $id
     *
     * @return Response|RedirectResponse
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

            if ($this->getRedirectResponse() instanceof RedirectResponse) {
                return $this->getRedirectResponse();
            }
        }

        if ($id !== null) {
            $deleteForm = $this->formFactory->create(DeleteType::class, $form->getData());

            return new Response(
                $this->engine->render(
                    'SumoCodersFrameworkMultiUserBundle:User:base.html.twig',
                    [
                        'form' => $form->createView(),
                        'deleteForm' => $deleteForm->createView(),
                        'user' => $form->getData()->getEntity(),
                    ]
                )
            );
        }

        return new Response(
            $this->engine->render(
                'SumoCodersFrameworkMultiUserBundle:User:base.html.twig',
                [
                    'form' => $form->createView(),
                ]
            )
        );
    }

    protected function getRedirectResponse(): ?RedirectResponse
    {
        if ($this->redirectRoute !== null) {
            return new RedirectResponse($this->router->generate($this->redirectRoute));
        }

        return null;
    }

    protected function getFormForId(?int $id = null): FormInterface
    {
        if ($id === null) {
            return $this->formFactory->create(
                get_class($this->form)
            );
        }

        $user = $this->userRepository->find((int) $id);

        /** @var UserDataTransferObject $dataTransferObjectClass */
        $dataTransferObjectClass = $this->form::getDataTransferObjectClass();
        $dataTransferObject = $dataTransferObjectClass::fromUser($user);

        return $this->formFactory->create(
            get_class($this->form),
            $dataTransferObject
        );
    }
}
