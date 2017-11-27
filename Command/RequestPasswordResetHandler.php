<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\RequestPasswordDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\Event\PasswordResetTokenCreated;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;
use SumoCoders\FrameworkMultiUserBundle\User\BaseUserRepositoryCollection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RequestPasswordResetHandler
{
    /** @var BaseUserRepositoryCollection */
    private $userRepositoryCollection;

    /** @var EventDispatcherInterface */
    private $dispatcher;

    public function __construct(
        BaseUserRepositoryCollection $userRepositoryCollection,
        EventDispatcherInterface $dispatcher
    ) {
        $this->userRepositoryCollection = $userRepositoryCollection;
        $this->dispatcher = $dispatcher;
    }

    public function handle(RequestPasswordDataTransferObject $dataTransferObject): void
    {
        $user = $this->userRepositoryCollection->findUserByUserName($dataTransferObject->userName);

        $user->generatePasswordResetToken();
        $repository = $this->userRepositoryCollection->findRepositoryByClassName(get_class($user));
        $repository->save($user);

        $this->sendPasswordResetToken($user);
    }

    private function sendPasswordResetToken(User $user): void
    {
        $event = new PasswordResetTokenCreated($user);
        $this->dispatcher->dispatch(PasswordResetTokenCreated::NAME, $event);
    }
}
