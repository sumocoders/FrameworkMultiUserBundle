<?php

namespace SumoCoders\FrameworkMultiUserBundle\Controller;

use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\TranslatorInterface;

class BlockController
{
    /** @var UserRepository */
    private $userRepository;

    /** @var FlashBagInterface */
    private $flashBag;

    /** @var TranslatorInterface */
    private $translator;

    /** @var Router */
    private $router;

    /** @var string */
    private $redirectRoute;

    public function __construct(
        UserRepository $userRepository,
        FlashBagInterface $flashBag,
        TranslatorInterface $translator,
        Router $router,
        string $redirectRoute
    ) {
        $this->userRepository = $userRepository;
        $this->flashBag = $flashBag;
        $this->translator = $translator;
        $this->router = $router;
        $this->redirectRoute = $redirectRoute;
    }

    public function toggleAction(int $id): RedirectResponse
    {
        $user = $this->userRepository->find($id);
        $user->toggleBlock();
        $this->userRepository->save($user);

        if ($this->redirectRoute !== null) {
            $this->flashBag->add(
                'success',
                $this->translator->trans(
                    'sumocoders.multiuserbundle.flash.' . ($user->isBlocked() ? 'block_success' : 'unblock_success')
                )
            );

            return new RedirectResponse($this->router->generate($this->redirectRoute));
        }

        return new RedirectResponse('/');
    }
}
