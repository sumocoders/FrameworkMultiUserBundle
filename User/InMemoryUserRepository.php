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

        $this->users[] = $user;

        $passwordResetUSer = new User(
            'reset',
            'reset',
            'reset'
        );

        $passwordResetUSer->generatePasswordResetToken();
        $this->users[] = $passwordResetUSer;
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
        foreach ($this->users as $user) {
            if ($user->getPasswordResetToken() === $token) {
                return $user;
            }
        }

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedClass()
    {
        return User::class;
    }

    /**
     * {@inheritdoc}
     */
    public function add(UserInterface $user)
    {
        $this->users[] = $user;
    }
    
    /**
     * {@inheritdoc}
     */
    public function save(UserInterface $user)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function update(UserInterface $userToUpdate, UserInterface $user)
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
    public function delete(UserInterface $user)
    {
        foreach ($this->users as $key => $row) {
            if ($row->getUserName() === $user->getUserName()) {
                unset($this->users[$key]);
                break;
            }
        }
    }
}
