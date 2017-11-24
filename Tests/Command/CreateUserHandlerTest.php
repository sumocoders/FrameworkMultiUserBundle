<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use PHPUnit_Framework_TestCase;
use SumoCoders\FrameworkMultiUserBundle\Command\CreateUserHandler;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\BaseUserDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryBaseUserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\BaseUserRepositoryCollection;
use SumoCoders\FrameworkMultiUserBundle\Entity\BaseUser;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;

class CreateUserHandlerTest extends PHPUnit_Framework_TestCase
{
    /** @var UserRepository */
    private $userRepository;

    /** @var BaseUserRepositoryCollection */
    private $userRepositoryCollection;

    public function setUp()
    {
        $this->userRepository = new InMemoryBaseUserRepository();
        $this->userRepositoryCollection = new BaseUserRepositoryCollection([$this->userRepository]);
    }

    /**
     * Test if CreateUserHandler gets handled.
     */
    public function testCreateUserGetsHandled()
    {
        $handler = new CreateUserHandler(
            new EncoderFactory([BaseUser::class => new PlaintextPasswordEncoder()]),
            $this->userRepositoryCollection
        );

        $userDataTransferObject = new BaseUserDataTransferObject();
        $userDataTransferObject->userName = 'sumo';
        $userDataTransferObject->plainPassword = 'randomPassword';
        $userDataTransferObject->displayName = 'sumocoders';
        $userDataTransferObject->email = 'sumo@example.dev';

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
