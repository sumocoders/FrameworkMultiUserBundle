<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use PHPUnit_Framework_TestCase;
use SumoCoders\FrameworkMultiUserBundle\Command\CreateUserHandler;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\UserDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryUserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use SumoCoders\FrameworkMultiUserBundle\User\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;

class CreateUserHandlerTest extends PHPUnit_Framework_TestCase
{
    /** @var UserRepository */
    private $userRepository;

    /** @var UserRepositoryCollection */
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
        $handler = new CreateUserHandler(
            new EncoderFactory([User::class => new PlaintextPasswordEncoder()]),
            $this->userRepositoryCollection
        );

        $user = new User('sumo', 'randomPassword', 'sumocoders', 'sumo@example.dev');

        $userDataTransferObject = UserDataTransferObject::fromUser($user);
        $userDataTransferObject->plainPassword = 'randomPassword';

        $handler->handle($userDataTransferObject);

        $this->assertEquals(
            'sumo',
            $this->userRepository->findByUsername('sumo')->getUsername()
        );
        $this->assertEquals(
            'sumocoders',
            $this->userRepository->findByUsername('sumo')->getDisplayName()
        );
        $this->assertEquals(
            'randomPassword{' . $this->userRepository->findByUsername('sumo')->getSalt() . '}',
            $this->userRepository->findByUsername('sumo')->getPassword()
        );
        $this->assertEquals(
            'sumo@example.dev',
            $this->userRepository->findByUsername('sumo')->getEmail()
        );
    }
}
