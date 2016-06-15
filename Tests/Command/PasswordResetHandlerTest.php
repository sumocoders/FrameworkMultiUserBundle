<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use SumoCoders\FrameworkMultiUserBundle\Command\ResetPassword;
use SumoCoders\FrameworkMultiUserBundle\Command\PasswordResetHandler;
use SumoCoders\FrameworkMultiUserBundle\Exception\InvalidPasswordConfirmationException;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryUserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\User;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;

class PasswordResetHandlerTest extends \PHPUnit_Framework_TestCase
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
     * Test if PasswordResetHandler throws error.
     */
    public function testPasswordResetThrowsError()
    {
        $handler = new PasswordResetHandler($this->userRepositoryCollection);

        $user = $this->userRepository->findByUsername('wouter');
        $event = new ResetPassword($user, 'password', 'wrong_confirmation');

        $this->setExpectedException(InvalidPasswordConfirmationException::class);

        $handler->handle($event);
    }

    public function testPasswordResetGetsHandled()
    {
        $handler = new PasswordResetHandler($this->userRepositoryCollection);

        $user = $this->userRepository->findByUsername('reset');
        $event = new ResetPassword($user, 'password', 'password');

        $user = $this->userRepositoryCollection
            ->findRepositoryByClassName(User::class)
            ->findByUsername('reset');

        $handler->handle($event);

        $updatedUser = $this->userRepositoryCollection
            ->findRepositoryByClassName(User::class)
            ->findByUsername('reset');

        $this->assertEquals($user->getUsername(), $updatedUser->getUsername());
        $this->assertNotEquals($user->getPassword(), $updatedUser->getPassword());
        $this->assertNotNull($user->getPasswordResetToken());
        $this->assertNull($updatedUser->getPasswordResetToken());
    }
}
