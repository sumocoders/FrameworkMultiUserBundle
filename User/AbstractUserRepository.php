<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository as UserRepositoryInterface;

abstract class AbstractUserRepository implements UserRepositoryInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var EntityRepository */
    protected $entityRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->entityRepository = $entityManager->getRepository(User::class);
    }

    public function add(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function find($id): ?User
    {
        return $this->entityRepository->find($id);
    }

    public function findByUsername(string $username): ?User
    {
        return $this->entityRepository->findOneBy(['username' => $username]);
    }

    public function findByEmailAddress(string $emailAddress): ?User
    {
        return $this->entityRepository->findOneBy(['email' => $emailAddress]);
    }

    abstract public function supportsClass(string $class): bool;

    public function save(User $user): void
    {
        $this->entityManager->flush();
    }

    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function findByPasswordResetToken(PasswordResetToken $token): ?User
    {
        return $this->entityRepository->findOneBy(['passwordResetToken' => $token->getToken()]);
    }
}
