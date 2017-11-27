<?php

namespace SumoCoders\FrameworkMultiUserBundle\User\Interfaces;

interface UserRepository extends PasswordResetRepository
{
    public function findByUsername(string $username): ?User;

    public function findByEmailAddress(string $emailAddress): ?User;

    public function supportsClass(string $class): bool;

    public function find($id);

    public function add(User $user): void;

    public function save(User $user): void;

    public function delete(User $user): void;
}
