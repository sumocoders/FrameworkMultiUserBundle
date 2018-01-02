<?php

namespace SumoCoders\FrameworkMultiUserBundle\User\Interfaces;

interface Blockable
{
    public function toggleBlock(): void;

    public function isBlocked(): bool;
}
