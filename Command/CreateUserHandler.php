<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces\UserDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\User\BaseUserRepositoryCollection;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

final class CreateUserHandler extends AbstractUserHandler
{
    /** @var BaseUserRepositoryCollection */
    private $userRepositoryCollection;

    /** @var EncoderFactoryInterface */
    private $encoderFactory;

    /**
     * @param EncoderFactoryInterface $encoderFactory
     * @param BaseUserRepositoryCollection $userRepositoryCollection
     */
    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        BaseUserRepositoryCollection $userRepositoryCollection
    ) {
        $this->userRepositoryCollection = $userRepositoryCollection;
        $this->encoderFactory = $encoderFactory;
    }

    public function handle(UserDataTransferObject $userDataTransferObject)
    {
        $newUser = $userDataTransferObject->getEntity();

        $newUser->encodePassword($this->encoderFactory->getEncoder($newUser));

        $repository = $this->getUserRepositoryForUser($this->userRepositoryCollection, $newUser);
        $repository->add($newUser);
    }
}
