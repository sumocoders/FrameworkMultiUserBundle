<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use SumoCoders\FrameworkMultiUserBundle\Exception\NoRepositoriesRegisteredException;
use SumoCoders\FrameworkMultiUserBundle\Exception\RepositoryNotRegisteredException;
use SumoCoders\FrameworkMultiUserBundle\Exception\UserNotFound;
use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;

class BaseUserRepositoryCollection
{
    /** @var UserRepository[] */
    private $userRepositories = [];

    public function __construct(array $userRepositories)
    {
        foreach ($userRepositories as $repository) {
            $this->addUserRepository($repository);
        }
    }

    public function addUserRepository(UserRepository $userRepository): void
    {
        $this->userRepositories[] = $userRepository;
    }

    /**
     * @throws NoRepositoriesRegisteredException
     *
     * @return UserRepository[]
     */
    public function all(): array
    {
        if (count($this->userRepositories) === 0) {
            throw new NoRepositoriesRegisteredException('No user repositories registered');
        }

        return $this->userRepositories;
    }

    /**
     * @param string $className
     *
     * @throws RepositoryNotRegisteredException
     *
     * @return UserRepository
     */
    public function findRepositoryByClassName(string $className): UserRepository
    {
        foreach ($this->userRepositories as $repository) {
            if ($repository->supportsClass($className)) {
                return $repository;
            }
        }

        throw RepositoryNotRegisteredException::withClassName($className);
    }

    /**
     * @param string $className
     *
     * @return bool
     */
    public function supportsClass(string $className): bool
    {
        foreach ($this->userRepositories as $repository) {
            if ($repository->supportsClass($className)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param PasswordResetToken $token
     *
     * @throws UserNotFound
     *
     * @return User
     */
    public function findUserByToken(PasswordResetToken $token): ?User
    {
        foreach ($this->userRepositories as $repository) {
            $user = $repository->findByPasswordResetToken($token);

            if ($user) {
                return $user;
            }
        }

        return null;
    }

    /**
     * @param string $username
     *
     * @throws UserNotFound
     *
     * @return User
     */
    public function findUserByUserName(string $username): User
    {
        foreach ($this->userRepositories as $repository) {
            $user = $repository->findByUsername($username);

            if ($user) {
                return $user;
            }
        }

        throw UserNotFound::withUsername($username);
    }
}
