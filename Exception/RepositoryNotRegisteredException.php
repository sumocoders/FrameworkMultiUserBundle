<?php

namespace SumoCoders\FrameworkMultiUserBundle\Exception;

use Exception;

final class RepositoryNotRegisteredException extends Exception
{
    /**
     * @param $classname
     * @return static
     */
    public static function withClassName($classname)
    {
        return new static('No repository has been registered for the '.$classname.' class.');
    }
}
