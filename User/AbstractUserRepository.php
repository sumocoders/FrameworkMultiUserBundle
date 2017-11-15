<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use Doctrine\ORM\EntityRepository;
use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository as UserRepositoryInterface;

abstract class AbstractUserRepository extends EntityRepository implements UserRepositoryInterface
{
    public function add(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findByUsername(string $username): ?User
    {
        return $this->findOneBy(['username' => $username]);
    }

    public function findByEmailAddress(string $emailAddress): ?User
    {
        return $this->findOneBy(['email' => $emailAddress]);
    }

    abstract public function supportsClass(string $class): bool;

    public function save(User $user): void
    {
        $this->getEntityManager()->flush();
    }

    public function delete(User $user): void
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }

    public function findByPasswordResetToken(PasswordResetToken $token): ?User
    {
        return $this->findOneBy(['passwordResetToken' => $token->getToken()]);
    }
}
