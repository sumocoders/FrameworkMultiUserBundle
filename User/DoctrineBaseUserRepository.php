<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use SumoCoders\FrameworkMultiUserBundle\Entity\BaseUser;

final class DoctrineBaseUserRepository extends UserRepository
{
    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return BaseUser::class === $class;
    }
}
