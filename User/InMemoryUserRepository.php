<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserWithPassword as UserWithPasswordInterface;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserWithPasswordRepository;

class InMemoryUserRepository implements UserWithPasswordRepository
{
    /** @var User[]|UserWithPasswordInterface[]|mixed[] */
    private $users = [];

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

    public function findByUsername($username)
    {
        foreach ($this->users as $user) {
            if ($user->getUsername() === $username) {
                return $user;
            }
        }
    }

    public function find($id)
    {
        foreach ($this->users as $user) {
            if ($user->getId() === $id) {
                return $user;
            }
        }
    }

    public function supportsClass($class)
    {
        return $class === UserWithPassword::class;
    }

    /**
     * @param string $token
     *
     * @return User|UserWithPasswordInterface|null
     */
    public function findByPasswordResetToken($token)
    {
        return $this->findByUsername('reset');
    }

    public function add(UserWithPasswordInterface $user)
    {
        $this->users[] = $user;
    }

    /**
     * {@inheritdoc}
     *
     * This does nothing here since the objects get updated by reference when changing them in the tests
     */
    public function save(UserWithPasswordInterface $user)
    {
    }

    public function delete(UserWithPasswordInterface $user)
    {
        foreach ($this->users as $key => $row) {
            if ($row->getUserName() === $user->getUserName()) {
                unset($this->users[$key]);
                break;
            }
        }
    }
}
