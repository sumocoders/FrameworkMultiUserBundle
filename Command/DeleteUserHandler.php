<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\User\UserRepository;

/**
 * Class DeleteUserHandler.
 */
class DeleteUserHandler
{
    private $userRepository;

    /**
     * DeleteUserHandler constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param DeleteUser $command
     */
    public function handle(DeleteUser $command)
    {
        $this->userRepository->delete($command->user);
    }
}
