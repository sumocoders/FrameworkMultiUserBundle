<?php

namespace SumoCoders\FrameworkMultiUserBundle\User\Interfaces;

interface Blockable
{
    /**
     * This will toggle the status of the user, between active and blocked.
     */
    public function toggleBlock();

    /**
     * This will check if the user is blocked.
     */
    public function isBlocked();
}
