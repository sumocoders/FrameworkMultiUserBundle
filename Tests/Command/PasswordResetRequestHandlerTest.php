<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use PHPUnit_Framework_TestCase;
use SumoCoders\FrameworkMultiUserBundle\Command\RequestPasswordResetHandler;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\RequestPasswordDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryBaseUserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\BaseUserRepositoryCollection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PasswordResetRequestHandlerTest extends PHPUnit_Framework_TestCase
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
    public function testPasswordResetRequestGetsHandled()
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
