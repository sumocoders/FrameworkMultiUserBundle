<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

/**
 * Class InMemoryUserRepository
 */
class InMemoryUserRepository implements UserRepository
{
    /** @var array */
    private $users = [];

    public function __construct()
    {
        $this->users[] = new User(
            'wouter',
            'test',
            'Wouter Sioen'
        );
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
     * {@inheritDoc}
     */
    public function add(User $user, $save = true)
    {
        $this->users[] = $user;
    }

    /**
     * {@inheritDoc}
     */
    public function save(User $user = null)
    {
        if($user === null){
            return;
        }

        $this->users[] = $user;
    }
}
