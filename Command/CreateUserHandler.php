<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\UserDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

final class CreateUserHandler extends AbstractUserHandler
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
     * CreateUserHandler constructor.
     *
     * @param UserRepositoryCollection $userRepositoryCollection
     */
    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        UserRepositoryCollection $userRepositoryCollection
    ) {
        $this->userRepositoryCollection = $userRepositoryCollection;
        $this->encoderFactory = $encoderFactory;
    }

    /**
    * @param UserDataTransferObject $userDataTransferObject
    */
    public function handle(UserDataTransferObject $userDataTransferObject)
    {
        $newUser = $userDataTransferObject->getEntity();

        $newUser->encodePassword($this->encoderFactory->getEncoder($newUser));

        $repository = $this->getUserRepositoryForUser($this->userRepositoryCollection, $newUser);
        $repository->add($newUser);
    }
}
