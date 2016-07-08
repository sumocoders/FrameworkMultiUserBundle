<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\UserDataTransferObject;

interface Handler
{
    public function handle(UserDataTransferObject $user);
}
