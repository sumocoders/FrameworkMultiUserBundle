<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;

/**
 * Class InMemoryUserRepository
 */
class InMemoryUserRepository implements UserRepository, PasswordResetRepository
{
    /** @var array */
    private $users = [];

    /**
     * InMemoryUserRepository constructor.
     */
    public function __construct()
    {
        $user = new UserWithPassword(
            'wouter',
            'test',
            'Wouter Sioen',
            'wouter@example.dev',
            1
        );

        $this->users[] = $user;

        $passwordResetUser = new UserWithPassword(
            'reset',
            'reset',
            'reset',
            'test@example.dev',
            2,
            PasswordResetToken::generate()
        );

        $this->users[] = $passwordResetUser;
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
    public function find($id)
    {
        foreach ($this->users as $user) {
            if ($user->getId() === $id) {
                return $user;
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $class === UserWithPassword::class;
    }

    /**
     * @param string $token
     *
     * @return UserInterface|null
     */
    public function findByPasswordResetToken($token)
    {
        return $this->findByUsername('reset');
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
     *
     * This does nothing here since the objects get updated by reference when changing them in the tests
     */
    public function save(User $user)
    {
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
