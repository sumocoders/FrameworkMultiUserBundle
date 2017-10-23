<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use Doctrine\ORM\EntityRepository;
use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository as UserRepositoryInterface;

abstract class AbstractUserRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * @param User $user
     */
    public function add(User $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $username
     *
     * @return null|User
     */
    public function findByUsername($username)
    {
        return $this->findOneBy(['username' => $username]);
    }

    /**
     * @param string $emailAddress
     *
     * @return User|null
     */
    public function findByEmailAddress($emailAddress)
    {
        return $this->findOneBy(['email' => $emailAddress]);
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    abstract public function supportsClass($class);

    /**
     * @param User $user
     */
    public function save(User $user)
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @param User $user
     */
    public function delete(User $user)
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @param PasswordResetToken $token
     *
     * @return null|User
     */
    public function findByPasswordResetToken(PasswordResetToken $token)
    {
        return $this->findOneBy(['passwordResetToken' => $token->getToken()]);
    }
}
