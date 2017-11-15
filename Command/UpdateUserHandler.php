<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces\UserDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\User\BaseUserRepositoryCollection;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

final class UpdateUserHandler extends AbstractUserHandler
{
    /** @var BaseUserRepositoryCollection */
    private $userRepositoryCollection;

    /** @var EncoderFactoryInterface */
    private $encoderFactory;

    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        BaseUserRepositoryCollection $userRepositoryCollection
    ) {
        $this->userRepositoryCollection = $userRepositoryCollection;
        $this->encoderFactory = $encoderFactory;
    }

    public function handle(UserDataTransferObject $userDataTransferObject): void
    {
        $userEntity = $userDataTransferObject->getEntity();

        $userEntity->encodePassword($this->encoderFactory->getEncoder($userEntity));
        $repository = $this->getUserRepositoryForUser($this->userRepositoryCollection, $userEntity);
        $repository->save($userEntity);
    }
}
