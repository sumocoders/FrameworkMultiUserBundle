<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use PHPUnit_Framework_TestCase;
use SumoCoders\FrameworkMultiUserBundle\Command\UpdateUserHandler;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\UserDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryUserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use SumoCoders\FrameworkMultiUserBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;

class UpdateUserHandlerTest extends PHPUnit_Framework_TestCase
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
     * Test if UpdateUserHandler gets handled.
     */
    public function testUpdateUserGetsHandled()
    {
        $handler = new UpdateUserHandler(
            new EncoderFactory([User::class => new PlaintextPasswordEncoder()]),
            $this->userRepositoryCollection
        );

        $user = $this->userRepository->findByUsername('wouter');
        $originalUser = clone $user;

        $baseUserTransferObject = UserDataTransferObject::fromUser($user);
        $baseUserTransferObject->displayName = 'test';
        $baseUserTransferObject->plainPassword = 'randomPassword';
        $baseUserTransferObject->email = 'test@test.be';

        $handler->handle($baseUserTransferObject);

        $this->assertNotEquals(
            'test',
            $this->userRepository->findByUsername('wouter')->getUsername()
        );
        $this->assertEquals(
            'test',
            $this->userRepository->findByUsername('wouter')->getDisplayName()
        );
        $this->assertEquals(
            'randomPassword{' . $this->userRepository->findByUsername('wouter')->getSalt() . '}',
            $this->userRepository->findByUsername('wouter')->getPassword()
        );
        $this->assertNotEquals(
            $originalUser->getDisplayName(),
            $this->userRepository->findByUsername('wouter')->getDisplayName()
        );
        $this->assertNotEquals(
            $originalUser->getPassword(),
            $this->userRepository->findByUsername('wouter')->getPassword()
        );
    }
}
