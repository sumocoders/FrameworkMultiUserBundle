<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use SumoCoders\FrameworkMultiUserBundle\Command\UpdateUser;
use SumoCoders\FrameworkMultiUserBundle\Command\UpdateUserHandler;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryUserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepository;

class UpdateUserHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
    }

    /**
     * Test if UpdateUserHandler gets handled.
     */
    public function testUpdateUserGetsHandled()
    {
        $handler = new UpdateUserHandler($this->userRepository);

        $updatingUser = $this->userRepository->findByUsername('wouter');

        $command = new UpdateUser($updatingUser, 'wouter', 'randomPassword', 'sumocoders');

        $handler->handle($command);

        $this->assertEquals(
            'wouter',
            $this->userRepository->findByUsername('wouter')->getUsername()
        );
        $this->assertEquals(
            'sumocoders',
            $this->userRepository->findByUsername('wouter')->getDisplayName()
        );
        $this->assertEquals(
            'randomPassword',
            $this->userRepository->findByUsername('wouter')->getPassword()
        );
        $this->assertNotEquals(
            $updatingUser->getDisplayName(),
            $this->userRepository->findByUsername('wouter')->getDisplayName()
        );
        $this->assertNotEquals(
            $updatingUser->getPassword(),
            $this->userRepository->findByUsername('wouter')->getPassword()
        );
    }
}
