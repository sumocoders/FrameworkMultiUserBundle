<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use Doctrine\ORM\EntityRepository;
use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User as UserInterface;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserRepository as UserRepositoryInterface;

abstract class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * @param UserInterface $user
     */
    public function add(UserInterface $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $username
     *
     * @return null|UserInterface
     */
    public function findByUsername($username)
    {
        return $this->findOneBy(['username' => $username]);
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    abstract public function supportsClass($class);

    /**
     * @param UserInterface $user
     */
    public function save(UserInterface $user)
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @param UserInterface $user
     */
    public function delete(UserInterface $user)
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @param PasswordResetToken $token
     *
     * @return null|UserInterface
     */
    public function findByPasswordResetToken(PasswordResetToken $token)
    {
        return $this->findOneBy(['passwordResetToken' => $token->getToken()]);
    }
}
