<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\User;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepository;

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
        $updatingUser = $command->getUser();
        $user = new User($command->getUsername(), $command->getPassword(), $command->getDisplayName());
        $this->userRepository->update($updatingUser, $user);
    }
}
