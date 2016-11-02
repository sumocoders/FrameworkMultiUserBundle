<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces\UserDataTransferObject;

interface Handler
{
    /**
     * @param UserDataTransferObject $user
     */
    public function handle(UserDataTransferObject $user);
}
