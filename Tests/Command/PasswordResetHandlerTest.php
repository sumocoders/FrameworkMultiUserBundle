<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use SumoCoders\FrameworkMultiUserBundle\Command\ResetPasswordHandler;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Form\ChangePassword;
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
     * Test if PAsswordResetHandler gets handled.
     *
     * @throws InvalidPasswordConfirmationException
     */
    public function testPasswordResetGetsHandled()
    {
        $handler = new ResetPasswordHandler($this->userRepositoryCollection);

        $user = $this->userRepository->findByUsername('reset');

        $changePasswordTransferObject = ChangePassword::forUser($user);
        $changePasswordTransferObject->newPassword = 'changedPassword';

        $user = $this->userRepositoryCollection
            ->findRepositoryByClassName(User::class)
            ->findByUsername('reset');
        $password = $user->getPassword();
        $token = $user->getPasswordResetToken();

        $handler->handle($changePasswordTransferObject);

        $updatedUser = $this->userRepositoryCollection
            ->findRepositoryByClassName(User::class)
            ->findByUsername('reset');

        $this->assertEquals($user->getUsername(), $updatedUser->getUsername());
        $this->assertNotEquals($password, $updatedUser->getPassword());
        $this->assertNotNull($token);
        $this->assertNull($updatedUser->getPasswordResetToken());
    }
}
