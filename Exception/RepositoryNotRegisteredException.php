<?php

namespace SumoCoders\FrameworkMultiUserBundle\Exception;

use Exception;

final class RepositoryNotRegisteredException extends Exception
{
    public static function withClassName(string $classname): self
    {
        return new static('No repository has been registered for the '.$classname.' class.');
    }
}
