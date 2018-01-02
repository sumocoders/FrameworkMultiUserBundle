<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use SumoCoders\FrameworkMultiUserBundle\Entity\BaseUser;

final class DoctrineBaseUserRepository extends AbstractUserRepository
{
    public function supportsClass(string $class): bool
    {
        return BaseUser::class === $class;
    }
}
