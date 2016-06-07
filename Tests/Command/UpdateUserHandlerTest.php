<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use SumoCoders\FrameworkMultiUserBundle\Command\UpdateUser;
use SumoCoders\FrameworkMultiUserBundle\Command\UpdateUserHandler;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryUserRepository;

class UpdateUserHandlerTest extends \PHPUnit_Framework_TestCase
{
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

        $command = new UpdateUser();
        $command->username = 'wouter';
        $command->displayName = 'sumocoders';
        $command->password = 'randomPassword';

        $updatingUser = $this->userRepository->findByUsername('wouter');

        $command->user = $updatingUser;

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
