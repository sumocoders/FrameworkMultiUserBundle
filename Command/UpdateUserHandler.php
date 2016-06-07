<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\User;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepository;

/**
 * Class CreateUserHandler.
 */
class UpdateUserHandler
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
     * @param UpdateUser $command
     */
    public function handle(UpdateUser $command)
    {
        $updatingUser = $command->user;
        $user = new User($command->username, $command->password, $command->displayName);
        $this->userRepository->update($updatingUser, $user);
    }
}
