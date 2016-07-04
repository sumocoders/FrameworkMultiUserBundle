<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

/**
 * Interface UserRepository
 */
interface UserRepository
{
    /**
     * @param string $username
     *
     * @return UserInterface|null
     */
    public function findByUsername($username);

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class);

    /**
     * @return string
     */
    public function getSupportedClass();

    /**
     * @param $id
     *
     * @return UserInterface
     */
    public function find($id);

    /**
     * Saves the given user.
     *
     * @param UserInterface $user
     */
    public function add(UserInterface $user);

    /**
     * Saves the given user.
     *
     * @param UserInterface $user
     */
    public function save(UserInterface $user);

    /**
     * Update an existing user.
     *
     * @param UserInterface $user
     */
    public function update(UserInterface $user);

    /**
     * Delete an existing user.
     *
     * @param UserInterface $user
     */
    public function delete(UserInterface $user);
}
