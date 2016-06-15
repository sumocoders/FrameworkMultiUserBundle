<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

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
        $user = new User(
            'wouter',
            'test',
            'Wouter Sioen',
            'wouter@example.dev'
        );

        $this->users[] = $user;

        $passwordResetUser = new User(
            'reset',
            'reset',
            'reset',
            'test@example.dev'
        );

        $passwordResetUser->generatePasswordResetToken();
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
    public function supportsClass($class)
    {
        return $class === User::class;
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
