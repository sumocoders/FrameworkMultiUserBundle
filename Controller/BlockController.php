<?php

namespace SumoCoders\FrameworkMultiUserBundle\Controller;

use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\TranslatorInterface;

final class BlockController
{
    /** @var UserRepository */
    private $userRepository;

    /** @var FlashBagInterface */
    private $flashbag;

    /** @var TranslatorInterface */
    private $translator;

    /** @var Router */
    private $router;

    /** @var string */
    private $redirectRoute;

    /**
     * @param UserRepository $userRepository
     * @param FlashBagInterface $flashbag
     * @param TranslatorInterface $translator
     * @param Router $router
     * @param string $redirectRoute
     */
    public function __construct(
        UserRepository $userRepository,
        FlashBagInterface $flashbag,
        TranslatorInterface $translator,
        Router $router,
        $redirectRoute
    ) {
        $this->userRepository = $userRepository;
        $this->flashbag = $flashbag;
        $this->translator = $translator;
        $this->router = $router;
        $this->redirectRoute = $redirectRoute;
    }

    /**
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function toggleAction($id)
    {
        $user = $this->userRepository->find($id);
        $user->toggleBlock();
        $this->userRepository->save($user);

        if ($this->redirectRoute !== null) {
            $translation = $user->isBlocked()
                ? $this->translator->trans('sumocoders.multiuserbundle.flash.block_success')
                : $this->translator->trans('sumocoders.multiuserbundle.flash.unblock_success');

            $this->flashbag->add('success', $translation);

            return new RedirectResponse($this->router->generate($this->redirectRoute));
        }

        return new RedirectResponse('/');
    }
}
