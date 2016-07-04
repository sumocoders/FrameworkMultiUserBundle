<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use Doctrine\ORM\EntityNotFoundException;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Form\RequestPassword;
use SumoCoders\FrameworkMultiUserBundle\Event\PasswordResetTokenCreated;
use SumoCoders\FrameworkMultiUserBundle\User\PasswordReset as UserPasswordReset;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RequestPasswordResetHandler
{
    /**
     * @var UserRepositoryCollection
     */
    private $userRepositoryCollection;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * PasswordResetRequestHandler constructor.
     *
     * @param UserRepositoryCollection $userRepositoryCollection
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        UserRepositoryCollection $userRepositoryCollection,
        EventDispatcherInterface $dispatcher
    ) {
        $this->userRepositoryCollection = $userRepositoryCollection;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Creates a password reset token and sends an email to the user.
     *
     * @param RequestPassword $dataTransferObject
     *
     * @throws EntityNotFoundException
     */
    public function handle(RequestPassword $dataTransferObject)
    {
        $user = $this->userRepositoryCollection->findUserByUserName($dataTransferObject->userName);

        if ($user === null) {
            throw new EntityNotFoundException();
        }

        $user->generatePasswordResetToken();
        $repository = $this->userRepositoryCollection->findRepositoryByClassName(get_class($user));
        $repository->save($user);

        $this->sendPasswordResetToken($user);
    }

    /**
     * Sends the password reset token to the user.
     *
     * @param UserPasswordReset $user
     */
    private function sendPasswordResetToken(UserPasswordReset $user)
    {
        $event = new PasswordResetTokenCreated($user);
        $this->dispatcher->dispatch(PasswordResetTokenCreated::NAME, $event);
    }
}
