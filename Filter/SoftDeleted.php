<?php

namespace SumoCoders\FrameworkMultiUserBundle\Filter;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;
use SumoCoders\FrameworkMultiUserBundle\Traits\SoftDeletable;

class SoftDeleted extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (in_array(SoftDeletable::class, $targetEntity->getReflectionClass()->getTraitNames())) {
            return $targetTableAlias . '.isDeleted = 0';
        }

        return '';
    }
}
