<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use PHPUnit_Framework_TestCase;
use SumoCoders\FrameworkMultiUserBundle\Command\RequestPasswordResetHandler;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\RequestPasswordDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\Entity\BaseUser;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryBaseUserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\BaseUserRepositoryCollection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;

class PasswordResetRequestHandlerTest extends PHPUnit_Framework_TestCase
{
    /** @var UserRepository */
    private $userRepository;

    /** @var BaseUserRepositoryCollection */
    private $userRepositoryCollection;

    public function setUp(): void
    {
        $this->userRepository = new InMemoryBaseUserRepository(
            new EncoderFactory([BaseUser::class => new PlaintextPasswordEncoder()])
        );
        $this->userRepositoryCollection = new BaseUserRepositoryCollection([$this->userRepository]);
    }

    /**
     * Test if CreateUserHandler gets handled.
     */
    public function testPasswordResetRequestGetsHandled(): void
    {
        $dispatcherMock = $this->getMockBuilder(EventDispatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $dispatcherMock->method('addListener');

        $handler = new RequestPasswordResetHandler(
            $this->userRepositoryCollection,
            $dispatcherMock
        );

        $requestPasswordTransferObject = new RequestPasswordDataTransferObject();
        $requestPasswordTransferObject->userName = 'wouter';

        $this->assertNull($handler->handle($requestPasswordTransferObject));
    }
}
