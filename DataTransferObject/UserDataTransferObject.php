<?php

namespace SumoCoders\FrameworkMultiUserBundle\DataTransferObject;

use SumoCoders\FrameworkMultiUserBundle\User\User;

interface UserDataTransferObject
{
    public static function fromUser(User $user);
    public function getEntity();
}
