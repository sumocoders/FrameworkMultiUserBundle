<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository as UserRepositoryInterface;

abstract class AbstractUserRepository extends ServiceEntityRepository implements UserRepositoryInterface
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

    public function supportsClass(string $class): bool
    {
        return $this->getClassName() === $class;
    }

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
