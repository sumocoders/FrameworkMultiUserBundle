<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use SumoCoders\FrameworkMultiUserBundle\Command\RequestPasswordReset;
use SumoCoders\FrameworkMultiUserBundle\Command\RequestPasswordResetHandler;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Form\RequestPassword;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryUserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PasswordResetRequestHandlerTest extends \PHPUnit_Framework_TestCase
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

        $dataTransferObject = new RequestPassword();
        $dataTransferObject->userName = 'wouter';

        $this->assertNull($handler->handle($dataTransferObject));
    }
}
