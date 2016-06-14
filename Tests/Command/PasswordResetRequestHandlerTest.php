<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use SumoCoders\FrameworkMultiUserBundle\Command\PasswordResetRequest;
use SumoCoders\FrameworkMultiUserBundle\Command\PasswordResetRequestHandler;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryUserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Swift_Mailer;

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
        $mailerMock = $this->getMockBuilder(Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mailerMock->method('send')->willReturn(1);

        $handler = new PasswordResetRequestHandler($this->userRepositoryCollection, $mailerMock, 'testing');

        $user = $this->userRepository->findByUsername('wouter');
        $event = new PasswordResetRequest($user);

        $this->assertEquals(1, $handler->handle($event));
    }
}
