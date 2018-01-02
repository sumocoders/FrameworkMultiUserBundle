<?php

namespace SumoCoders\FrameworkMultiUserBundle\ValueObject;

use SumoCoders\FrameworkMultiUserBundle\Exception\InvalidStatusException;

final class Status
{
    const ACTIVE = 'active';
    const BLOCKED = 'blocked';

    /** @var string */
    private $status;

    /**
     * @param string $status
     *
     * @throws InvalidStatusException
     */
    private function __construct(string $status)
    {
        if (!in_array($status, self::getPossibleStatuses())) {
            throw InvalidStatusException::withStatus($status);
        }

        $this->status = $status;
    }

    public static function fromString(string $status): self
    {
        return new self($status);
    }

    public static function getPossibleStatuses(): array
    {
        $statuses = [
            self::ACTIVE,
            self::BLOCKED,
        ];

        return array_combine($statuses, $statuses);
    }

    public static function active(): self
    {
        return new self(self::ACTIVE);
    }

    public static function blocked(): self
    {
        return new self(self::BLOCKED);
    }

    public function isBlocked(): bool
    {
        return $this->status === self::BLOCKED;
    }

    public function __toString(): string
    {
        return $this->status;
    }
}
