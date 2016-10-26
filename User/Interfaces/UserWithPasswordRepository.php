<?php

namespace SumoCoders\FrameworkMultiUserBundle\User\Interfaces;

interface UserWithPasswordRepository extends PasswordResetRepository
{
    /**
     * @param string $username
     *
     * @return UserWithPassword|null
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
     * @return UserWithPassword
     */
    public function find($id);

    /**
     * Saves the given user.
     *
     * @param UserWithPassword $user
     */
    public function add(UserWithPassword $user);

    /**
     * Saves the given user.
     *
     * @param UserWithPassword $user
     */
    public function save(UserWithPassword $user);

    /**
     * Delete an existing user.
     *
     * @param UserWithPassword $user
     */
    public function delete(UserWithPassword $user);
}
