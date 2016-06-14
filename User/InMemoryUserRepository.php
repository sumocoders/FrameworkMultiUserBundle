<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

/**
 * Class InMemoryUserRepository
 */
class InMemoryUserRepository implements UserRepository, PasswordResetRepositoryInterface
{
    /** @var array */
    private $users = [];

    public function __construct()
    {
        $user = new User(
            'wouter',
            'test',
            'Wouter Sioen'
        );
        
        $user->generatePasswordResetToken();
        $this->users[] = $user;
    }

    /**
     * {@inheritDoc}
     */
    public function findByUsername($username)
    {
        foreach ($this->users as $user) {
            if ($user->getUsername() === $username) {
                return $user;
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $class === User::class;
    }

    /**
     * @param string $token
     * @return UserInterface|null
     */
    public function findByPasswordResetToken($token)
    {
        foreach ($this->users as $user){
            if ($user->getPasswordResetToken() === $token){
                return $user;
            }
        }
        
        return;
    }
}
