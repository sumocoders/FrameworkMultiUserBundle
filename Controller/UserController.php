<?php

namespace SumoCoders\FrameworkMultiUserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SumoCoders\FrameworkMultiUserBundle\Command\Handler;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * This class handles all the user actions.
 * Register a service for each action.
 */
class UserController extends Controller
{
    /**
     * @var Handler
     */
    private $handler;

    /**
     * @var FormTypeInterface
     */
    private $form;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var string
     */
    private $redirectRoute;

    /**
     * @param ContainerInterface $container
     * @param FormTypeInterface $form
     * @param Handler $handler
     * @param UserRepository $userRepository
     * @param string $redirectRoute = null
     */
    public function __construct(
        ContainerInterface $container,
        FormTypeInterface $form,
        Handler $handler,
        UserRepository $userRepository,
        $redirectRoute = null
    ) {
        $this->form = $form;
        $this->handler = $handler;
        $this->userRepository = $userRepository;
        $this->redirectRoute = $redirectRoute;
        $this->setContainer($container);
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
        $form = $this->getFormForId((int) $id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = $form->getData();
            $this->handler->handle($command);

            if ($this->redirectRoute !== null) {
                return $this->redirect($this->redirectRoute);
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
            return $this->createForm($this->form);
        }

        $user = $this->userRepository->find($id);
        $dataTransferObjectClass = $this->form->getDataTransferObjectClass();
        $dataTransferObject = $dataTransferObjectClass::fromUser($user);

        return $this->createForm($this->form, $dataTransferObject);
    }
}
