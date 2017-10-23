<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use SumoCoders\FrameworkMultiUserBundle\Entity\BaseUser;

final class DoctrineBaseAbstractUserRepository extends AbstractUserRepository
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
