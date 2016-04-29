<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface UserRepository
 */
interface UserRepository
{
    /**
     * @param string $username
     * @return UserInterface|null
     */
    public function findByUsername($username);

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class);
}
