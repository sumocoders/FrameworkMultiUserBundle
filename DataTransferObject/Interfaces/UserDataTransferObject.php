<?php

namespace SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces;

use Doctrine\Common\Collections\Collection;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;

interface UserDataTransferObject
{
    public function getId(): ?int;

    public function getUserName(): ?string;

    public function getDisplayName(): ?string;

    public function getEmail(): ?string;

    public function getPlainPassword(): ?string;

    public static function fromUser(User $user): self;

    public function getEntity(): User;

    public function getRoles(): array;
}
