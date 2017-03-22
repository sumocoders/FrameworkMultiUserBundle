<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use SumoCoders\FrameworkMultiUserBundle\Exception\NoRepositoriesRegisteredException;
use SumoCoders\FrameworkMultiUserBundle\Exception\RepositoryNotRegisteredException;
use SumoCoders\FrameworkMultiUserBundle\Exception\UserNotFound;
use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;

class UserRepositoryCollection
{
    /** @var UserRepository[] */
    private $userRepositories = [];

    /**
     * @param UserRepository[] $userRepositories
     */
    public function __construct(array $userRepositories)
    {
        foreach ($userRepositories as $repository) {
            $this->addUserRepository($repository);
        }
    }

    /**
     * Registers the UserRepository to the UserRepositoryCollection.
     *
     * @param UserRepository $userRepository
     */
    public function addUserRepository(UserRepository $userRepository)
    {
        $this->userRepositories[] = $userRepository;
    }

    /**
     * Get the userRepositories.
     *
     * @throws NoRepositoriesRegisteredException
     *
     * @return UserRepository[]
     */
    public function all()
    {
        if (count($this->userRepositories) === 0) {
            throw new NoRepositoriesRegisteredException('No user repositories registered');
        }

        return $this->userRepositories;
    }

    /**
     * Find the UserRepository for a given User Class.
     *
     * @param string $className
     *
     * @throws RepositoryNotRegisteredException
     *
     * @return UserRepository
     */
    public function findRepositoryByClassName($className)
    {
        foreach ($this->userRepositories as $repository) {
            if ($repository->supportsClass($className)) {
                return $repository;
            }
        }

        throw RepositoryNotRegisteredException::withClassName($className);
    }

    /**
     * Check if the UserRepositoryCollection supports a User class.
     *
     * @param string $className
     *
     * @return bool
     */
    public function supportsClass($className)
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
    public function findUserByToken(PasswordResetToken $token)
    {
        foreach ($this->userRepositories as $repository) {
            $user = $repository->findByPasswordResetToken($token);

            if ($user) {
                return $user;
            }
        }

        throw UserNotFound::withToken($token);
    }

    /**
     * @param string $username
     *
     * @throws UserNotFound
     *
     * @return User
     */
    public function findUserByUserName($username)
    {
        foreach ($this->userRepositories as $repository) {
            $user = $repository->findByUsername($username);

            if ($user) {
                return $user;
            }
        }

        throw UserNotFound::withUsername($username);
    }

    /**
     * @param string $email
     *
     * @throws UserNotFound
     *
     * @return User
     */
    public function findUserByEmail($email)
    {
        foreach ($this->userRepositories as $repository) {
            $user = $repository->findByEmail($email);

            if ($user) {
                return $user;
            }
        }

        throw UserNotFound::withEmail($email);
    }
}
