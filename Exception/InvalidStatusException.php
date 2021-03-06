<?php

namespace SumoCoders\FrameworkMultiUserBundle\Exception;

use Exception;
use SumoCoders\FrameworkMultiUserBundle\ValueObject\Status;

final class InvalidStatusException extends Exception
{
    public static function withStatus(string $status): self
    {
        return new self(
            sprintf(
                'Invalid status %s, possible statuses are: %s.',
                $status,
                implode(', ', Status::getPossibleStatuses())
            )
        );
    }
}
