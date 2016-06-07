<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\User;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepository;

/**
 * Class CreateUserHandler.
 */
class CreateUserHandler
{
    private $userRepository;

    /**
     * CreateUserHandler constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param CreateUser $command
     */
    public function handle(CreateUser $command)
    {
        $user = new User($command->username, $command->password, $command->displayName);
        $this->userRepository->add($user);
    }
}
