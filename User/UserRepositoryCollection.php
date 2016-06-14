<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use SumoCoders\FrameworkMultiUserBundle\Exception\NoRepositoriesRegisteredException;
use SumoCoders\FrameworkMultiUserBundle\Exception\RepositoryNotRegisteredException;

class UserRepositoryCollection
{
    /**
     * @var array
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
     * @return array
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
     * @param $className
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
    
    public function findUserByToken($token)
    {
        foreach ($this->userRepositories as $repository) {
            $user = $repository->findByPasswordResetToken($token);
            
            if ($user) {
                return $user;
            }
        }
    }
}
