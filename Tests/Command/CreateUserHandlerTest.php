<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use SumoCoders\FrameworkMultiUserBundle\Command\CreateUser;
use SumoCoders\FrameworkMultiUserBundle\Command\CreateUserHandler;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryUserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\User;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;

class CreateUserHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserRepositoryCollection
     */
    private $userRepositoryCollection;

    public function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
        $this->userRepositoryCollection = new UserRepositoryCollection([$this->userRepository]);
    }

    /**
     * Test if CreateUserHandler gets handled.
     */
    public function testCreateUserGetsHandled()
    {
        $handler = new CreateUserHandler($this->userRepositoryCollection);

        $user = new CreateUser('sumo', 'randomPassword', 'sumocoders');

        $handler->handle($user, User::class);

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
