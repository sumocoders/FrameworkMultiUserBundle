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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === User::class;
    }

    /**
     * {@inheritdoc}
     */
    public function add(User $user)
    {
        $this->users[] = $user;
    }
    
    /**
     * {@inheritdoc}
     */
    public function save(User $user)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function update(User $userToUpdate, User $user)
    {
        foreach ($this->users as $key => $row) {
            if ($row->getUserName() === $user->getUserName()) {
                $this->users[$key] = $user;
                break;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete(User $user)
    {
        foreach ($this->users as $key => $row) {
            if ($row->getUserName() === $user->getUserName()) {
                unset($this->users[$key]);
                break;
            }
        }
    }
}
