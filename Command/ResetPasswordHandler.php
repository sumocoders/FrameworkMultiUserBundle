<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\ChangePasswordDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\Exception\InvalidPasswordConfirmationException;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class ResetPasswordHandler
{
    /**
     * @var UserRepositoryCollection
     */
    private $userRepositoryCollection;

    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * PasswordResetHandler constructor.
     *
     * @param UserRepositoryCollection $userRepositoryCollection
     * @param EncoderFactoryInterface $encoderFactory
     */
    public function __construct(
        UserRepositoryCollection $userRepositoryCollection,
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->userRepositoryCollection = $userRepositoryCollection;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param ChangePasswordDataTransferObject $dataTransferObject
     *
     * @throws InvalidPasswordConfirmationException
     */
    public function handle(ChangePasswordDataTransferObject $dataTransferObject)
    {
        $user = $dataTransferObject->user;
        $user->setPassword($dataTransferObject->newPassword);
        $user->encodePassword($this->encoderFactory->getEncoder($user));
        $user->clearPasswordResetToken();
        $repository = $this->userRepositoryCollection->findRepositoryByClassName(get_class($user));
        $repository->save($user);
    }
}
