<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use SumoCoders\FrameworkMultiUserBundle\Exception\NoRepositoriesRegisteredException;
use SumoCoders\FrameworkMultiUserBundle\Exception\RepositoryNotRegisteredException;
use SumoCoders\FrameworkMultiUserBundle\Exception\UserNotFound;
use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User as UserInterface;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserWithPassword as UserWithPasswordInterface;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserWithPasswordRepository;

class UserRepositoryCollection
{
    /**
     * @var UserRepository[]|UserWithPasswordRepository[]|mixed[]
     */
    private $userRepositories = [];

    /**
     * UserRepositoryCollection constructor.
     *
     * @param array $userRepositories
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
     * @param UserRepository|UserWithPasswordRepository $userRepository
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
     * @return UserRepository[]|UserWithPasswordRepository[]|mixed[]
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
     * @return UserRepository|UserWithPasswordRepository
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
     * @return UserInterface|UserWithPasswordInterface
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
     * @return UserInterface|UserWithPasswordInterface
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
}
