<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use SumoCoders\FrameworkMultiUserBundle\Command\DeleteUser;
use SumoCoders\FrameworkMultiUserBundle\Command\DeleteUserHandler;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryUserRepository;

class DeleteUserHandlerTest extends \PHPUnit_Framework_TestCase
{
    private $userRepository;

    public function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
    }

    /**
     * Test if DeleteUserHandler gets handled.
     */
    public function testUpdateUserGetsHandled()
    {
        $handler = new DeleteUserHandler($this->userRepository);

        $deletingUser = $this->userRepository->findByUsername('wouter');

        $command = new DeleteUser($deletingUser);

        $handler->handle($command);

        $this->assertNotNull($deletingUser);
        $this->assertNull(
            $this->userRepository->findByUsername('wouter')
        );
    }
}
