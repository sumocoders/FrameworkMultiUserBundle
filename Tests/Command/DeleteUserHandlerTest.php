<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Command;

use PHPUnit_Framework_TestCase;
use SumoCoders\FrameworkMultiUserBundle\Command\DeleteUserHandler;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\BaseUserDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryBaseUserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\BaseUserRepositoryCollection;

class DeleteUserHandlerTest extends PHPUnit_Framework_TestCase
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
     * Test if DeleteUserHandler gets handled.
     */
    public function testUpdateUserGetsHandled()
    {
        $handler = new DeleteUserHandler($this->userRepositoryCollection);

        $deletingUser = $this->userRepository->findByUsername('wouter');

        $handler->handle(BaseUserDataTransferObject::fromUser($deletingUser));

        $this->assertNotNull($deletingUser);
        $this->assertNull(
            $this->userRepository->findByUsername('wouter')
        );
    }
}
