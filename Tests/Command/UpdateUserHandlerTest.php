<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use SumoCoders\FrameworkMultiUserBundle\Command\UpdateUserHandler;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Form\BaseUser;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryUserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;

class UpdateUserHandlerTest extends \PHPUnit_Framework_TestCase
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
     * Test if UpdateUserHandler gets handled.
     */
    public function testUpdateUserGetsHandled()
    {
        $handler = new UpdateUserHandler($this->userRepositoryCollection);

        $user = $this->userRepository->findByUsername('wouter');

        $dataTransferObject = BaseUser::fromUser($user);
        $dataTransferObject->displayName = 'test';
        $dataTransferObject->password = 'randomPassword';
        $dataTransferObject->email = 'test@test.be';

        $handler->handle($dataTransferObject);

        $this->assertNotEquals(
            'test',
            $this->userRepository->findByUsername('wouter')->getUsername()
        );
        $this->assertEquals(
            'test',
            $this->userRepository->findByUsername('wouter')->getDisplayName()
        );
        $this->assertEquals(
            'randomPassword',
            $this->userRepository->findByUsername('wouter')->getPassword()
        );
        $this->assertNotEquals(
            $user->getDisplayName(),
            $this->userRepository->findByUsername('wouter')->getDisplayName()
        );
        $this->assertNotEquals(
            $user->getPassword(),
            $this->userRepository->findByUsername('wouter')->getPassword()
        );
    }
}
