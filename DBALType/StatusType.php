<?php

namespace SumoCoders\FrameworkMultiUserBundle\DBALType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use SumoCoders\FrameworkMultiUserBundle\ValueObject\Status;

final class StatusType extends Type
{
    const STATUS = 'user_status';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        $fieldDeclaration['length'] = 50;

        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * @param string|null $value
     * @param AbstractPlatform $platform
     *
     * @return Status|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Status
    {
        if ($value === null) {
            return null;
        }

        return Status::fromString($value);
    }

    /**
     * @param Status|null $value
     * @param AbstractPlatform $platform
     *
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        return (string) $value;
    }

    public function getName(): string
    {
        return self::STATUS;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
