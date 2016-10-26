<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces\UserWithPasswordDataTransferObject;

interface Handler
{
    public function handle(UserWithPasswordDataTransferObject $user);
}
