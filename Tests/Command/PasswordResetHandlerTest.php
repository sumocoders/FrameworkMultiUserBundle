<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use PHPUnit_Framework_TestCase;
use SumoCoders\FrameworkMultiUserBundle\Command\ResetPasswordHandler;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\ChangePasswordDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\Exception\InvalidPasswordConfirmationException;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryUserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use SumoCoders\FrameworkMultiUserBundle\User\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;

class PasswordResetHandlerTest extends PHPUnit_Framework_TestCase
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
     * Test if PAsswordResetHandler gets handled.
     *
     * @throws InvalidPasswordConfirmationException
     */
    public function testPasswordResetGetsHandled()
    {
        $handler = new ResetPasswordHandler(
            $this->userRepositoryCollection,
            new EncoderFactory([User::class => new PlaintextPasswordEncoder()])
        );

        $user = $this->userRepository->findByUsername('reset');

        $changePasswordTransferObject = ChangePasswordDataTransferObject::forUser($user);
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
