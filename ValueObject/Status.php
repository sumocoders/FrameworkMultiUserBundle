<?php

namespace SumoCoders\FrameworkMultiUserBundle\ValueObject;

use SumoCoders\FrameworkMultiUserBundle\Exception\InvalidStatusException;

final class Status
{
    private const ACTIVE = 'active';
    private const BLOCKED = 'blocked';
    private const INCOMPLETE = 'incomplete';
    private const PENDING = 'pending';

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
            self::INCOMPLETE,
            self::PENDING,
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

    public static function incomplete(): self
    {
        return new self(self::INCOMPLETE);
    }

    public static function pending(): self
    {
        return new self(self::PENDING);
    }

    public function isActive(): bool
    {
        return $this->status === self::ACTIVE;
    }

    public function isBlocked(): bool
    {
        return $this->status === self::BLOCKED;
    }

    public function isIncomplete(): bool
    {
        return $this->status === self::INCOMPLETE;
    }

    public function isPending(): bool
    {
        return $this->status === self::PENDING;
    }

    public function __toString(): string
    {
        return $this->status;
    }
}
