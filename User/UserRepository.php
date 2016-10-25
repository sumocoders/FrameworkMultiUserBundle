<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

/**
 * Interface UserRepository.
 */
interface UserRepository
{
    /**
     * @param string $username
     *
     * @return User|null
     */
    public function findByUsername($username);

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class);

    /**
     * @param $id
     *
     * @return User
     */
    public function find($id);

    /**
     * Saves the given user.
     *
     * @param User $user
     */
    public function add(User $user);

    /**
     * Saves the given user.
     *
     * @param User $user
     */
    public function save(User $user);

    /**
     * Delete an existing user.
     *
     * @param User $user
     */
    public function delete(User $user);
}
