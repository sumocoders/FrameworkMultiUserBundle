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
    private function __construct($status)
    {
        if (!in_array($status, self::getPossibleStatuses())) {
            throw InvalidStatusException::withStatus($status);
        }

        $this->status = $status;
    }

    public static function fromString($status)
    {
        return new self($status);
    }

    /**
     * @return array
     */
    public static function getPossibleStatuses()
    {
        $statuses = [
            self::ACTIVE,
            self::BLOCKED,
        ];

        return array_combine($statuses, $statuses);
    }

    /**
     * @return Status
     */
    public static function active()
    {
        return new self(self::ACTIVE);
    }

    /**
     * @return Status
     */
    public static function blocked()
    {
        return new self(self::BLOCKED);
    }

    /**
     * @return bool
     */
    public function isBlocked()
    {
        return $this->status === self::blocked();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->status;
    }
}
