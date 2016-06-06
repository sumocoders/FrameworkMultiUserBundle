<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use SumoCoders\FrameworkMultiUserBundle\Command\CreateUser;
use SumoCoders\FrameworkMultiUserBundle\Command\CreateUserHandler;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryUserRepository;

class CreateUserHandlerTest extends \PHPUnit_Framework_TestCase
{
    private $userRepository;

    public function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();

    }

    /**
     * Test if CreateUserHandler gets handled.
     */
    public function testCreateUserGetsHandled()
    {
        $handler = new CreateUserHandler($this->userRepository);

        $user = new CreateUser();
        $user->username = 'sumo';
        $user->displayName = 'sumocoders';
        $user->password = 'randomPassword';

        $handler->handle($user);

        $this->assertEquals(
            'sumo',
            $this->userRepository->findByUsername('sumo')->getUsername()
        );
        $this->assertEquals(
            'sumocoders',
            $this->userRepository->findByUsername('sumo')->getDisplayName()
        );
        $this->assertEquals(
            'randomPassword',
            $this->userRepository->findByUsername('sumo')->getPassword()
        );
    }
}
