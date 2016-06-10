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
     * @return string
     */
    public function getSupportedClass();

    /**
     * Saves the given user.
     *
     * @param User $user
     * @return void
     */
    public function add(User $user);

    /**
     * Saves the given user.
     *
     * @param User $user
     * @return void
     */
    public function save(User $user);

    /**
     * Update an existing user.
     *
     * @param User $userToUpdate
     * @param User $user
     * @return void
     */
    public function update(User $userToUpdate, User $user);

    /**
     * Delete an existing user.
     *
     * @param User $user
     * @return void
     */
    public function delete(User $user);
}
