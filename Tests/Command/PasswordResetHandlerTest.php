<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use PHPUnit_Framework_TestCase;
use SumoCoders\FrameworkMultiUserBundle\Command\ResetPasswordHandler;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\ChangePasswordDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\Exception\InvalidPasswordConfirmationException;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryBaseUserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\BaseUserRepositoryCollection;
use SumoCoders\FrameworkMultiUserBundle\Entity\BaseUser;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;

class PasswordResetHandlerTest extends PHPUnit_Framework_TestCase
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
     * Test if PAsswordResetHandler gets handled.
     *
     * @throws InvalidPasswordConfirmationException
     */
    public function testPasswordResetGetsHandled()
    {
        $handler = new ResetPasswordHandler(
            $this->userRepositoryCollection,
            new EncoderFactory([BaseUser::class => new PlaintextPasswordEncoder()])
        );

        $user = $this->userRepository->findByUsername('reset');

        $changePasswordTransferObject = ChangePasswordDataTransferObject::forUser($user);
        $changePasswordTransferObject->newPassword = 'changedPassword';

        $user = $this->userRepositoryCollection
            ->findRepositoryByClassName(BaseUser::class)
            ->findByUsername('reset');
        $password = $user->getPassword();
        $token = $user->getPasswordResetToken();

        $handler->handle($changePasswordTransferObject);

        $updatedUser = $this->userRepositoryCollection
            ->findRepositoryByClassName(BaseUser::class)
            ->findByUsername('reset');

        $this->assertEquals($user->getUsername(), $updatedUser->getUsername());
        $this->assertNotEquals($password, $updatedUser->getPassword());
        $this->assertNotNull($token);
        $this->assertNull($updatedUser->getPasswordResetToken());
    }
}
