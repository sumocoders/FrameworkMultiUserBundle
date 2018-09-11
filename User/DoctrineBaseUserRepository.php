<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use Doctrine\Common\Persistence\ManagerRegistry;
use SumoCoders\FrameworkMultiUserBundle\Entity\BaseUser;

final class DoctrineBaseUserRepository extends AbstractUserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BaseUser::class);
    }
}
