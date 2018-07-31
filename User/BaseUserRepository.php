<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use Doctrine\ORM\EntityManagerInterface;
use SumoCoders\FrameworkMultiUserBundle\Entity\BaseUser;

class BaseUserRepository extends AbstractUserRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);

        $this->entityRepository = $entityManager->getRepository(BaseUser::class);
    }

    public function supportsClass(string $class): bool
    {
        return BaseUser::class === $class;
    }
}