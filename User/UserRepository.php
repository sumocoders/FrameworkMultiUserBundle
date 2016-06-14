<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use SumoCoders\FrameworkMultiUserBundle\User\UserInterface;

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
     * @param UserInterface $user
     * @return void
     */
    public function add(UserInterface $user);

    /**
     * Saves the given user.
     *
     * @param UserInterface $user
     * @return void
     */
    public function save(UserInterface $user);

    /**
     * Update an existing user.
     *
     * @param UserInterface $userToUpdate
     * @param UserInterface $user
     * @return void
     */
    public function update(UserInterface $userToUpdate, UserInterface $user);

    /**
     * Delete an existing user.
     *
     * @param UserInterface $user
     * @return void
     */
    public function delete(UserInterface $user);
}
