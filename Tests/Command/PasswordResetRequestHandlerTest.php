<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use SumoCoders\FrameworkMultiUserBundle\Command\RequestPasswordReset;
use SumoCoders\FrameworkMultiUserBundle\Command\PasswordResetRequestHandler;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryUserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Swift_Mailer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

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

        $translatorMock = $this->getMockBuilder(TranslatorInterface::class)->getMock();

        $routerMock = $this->getMockBuilder(UrlGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $handler = new PasswordResetRequestHandler($this->userRepositoryCollection, $mailerMock, $translatorMock, $routerMock);

        $user = $this->userRepository->findByUsername('wouter');
        $event = new RequestPasswordReset($user);

        $this->assertEquals(1, $handler->handle($event));
    }
}
