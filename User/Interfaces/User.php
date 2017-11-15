<?php

namespace SumoCoders\FrameworkMultiUserBundle\User\Interfaces;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces\UserDataTransferObject;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface User extends UserInterface, PasswordReset, Blockable
{
    public function __toString(): string;

    public function getDisplayName(): string;

    public function getId(): int;

    public function change(UserDataTransferObject $data): void;

    public function hasPlainPassword(): bool;

    public function getPlainPassword(): string;

    public function encodePassword(PasswordEncoderInterface $encoder): void;
}
