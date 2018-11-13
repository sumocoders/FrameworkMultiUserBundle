<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use Doctrine\Common\Collections\ArrayCollection;
use SumoCoders\FrameworkMultiUserBundle\Entity\BaseUser;
use SumoCoders\FrameworkMultiUserBundle\Entity\UserRole;
use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository as UserRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class InMemoryBaseUserRepository implements UserRepositoryInterface
{
    /** @var BaseUser[] */
    private $users = [];

    public function __construct(EncoderFactory $encoderFactory)
    {
        $user = new BaseUser(
            'wouter',
            'test',
            'Wouter Sioen',
            'wouter@example.dev',
            new ArrayCollection([new UserRole(1)])
        );
        $user->encodePassword($encoderFactory->getEncoder($user));

        $this->users[] = $user;

        $passwordResetUser = new BaseUser(
            'reset',
            'reset',
            'reset',
            'test@example.dev',
            new ArrayCollection([new UserRole(1)]),
            PasswordResetToken::generate()
        );
        $passwordResetUser->encodePassword($encoderFactory->getEncoder($passwordResetUser));

        $this->users[] = $passwordResetUser;
    }

    public function findByUsername(string $username): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getUsername() === $username) {
                return $user;
            }
        }

        return null;
    }

    public function findByEmailAddress(string $emailAddress): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $emailAddress) {
                return $user;
            }
        }

        return null;
    }

    /**
     * @param int $id
     *
     * @return null|User
     */
    public function find($id): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getId() === $id) {
                return $user;
            }
        }

        return null;
    }

    public function supportsClass(string $class): bool
    {
        return $class === BaseUser::class;
    }

    public function findByPasswordResetToken(PasswordResetToken $token): ?User
    {
        return $this->findByUsername('reset');
    }

    public function add(User $user): void
    {
        $this->users[] = $user;
    }

    /**
     * This does nothing here since the objects get updated by reference when changing them in the tests
     */
    public function save(User $user): void
    {
    }

    public function delete(User $user): void
    {
        foreach ($this->users as $key => $row) {
            if ($row->getUserName() === $user->getUserName()) {
                unset($this->users[$key]);
                break;
            }
        }
    }
}
