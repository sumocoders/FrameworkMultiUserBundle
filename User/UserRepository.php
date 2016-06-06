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

    /**
     * Add User to the repository.
     *
     * @param User $user
     * @param bool $save
     * @return void
     */
    public function add(User $user, $save = true);

    /**
     * Flush the repository.
     *
     * @param User|null $user
     * @return void
     */
    public function save(User $user = null);
}
