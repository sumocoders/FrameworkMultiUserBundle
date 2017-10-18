<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use SumoCoders\FrameworkMultiUserBundle\Entity\BaseUser;
use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository as UserRepositoryInterface;

class InMemoryBaseUserRepository implements UserRepositoryInterface
{
    /** @var BaseUser[] */
    private $users = [];

    public function __construct()
    {
        $user = new BaseUser(
            'wouter',
            'test',
            'Wouter Sioen',
            'wouter@example.dev',
            1
        );

        $this->users[] = $user;

        $passwordResetUser = new BaseUser(
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

        return null;
    }

    /**
     * @param string $emailAddress
     *
     * @return User|null
     */
    public function findByEmailAddress($emailAddress)
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $emailAddress) {
                return $user;
            }
        }

        return null;
    }

    public function find($id)
    {
        foreach ($this->users as $user) {
            if ($user->getId() === $id) {
                return $user;
            }
        }

        return null;
    }

    public function supportsClass($class)
    {
        return $class === BaseUser::class;
    }

    public function findByPasswordResetToken(PasswordResetToken $token)
    {
        return $this->findByUsername('reset');
    }

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
