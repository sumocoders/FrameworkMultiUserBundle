<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use Symfony\Component\Security\Core\User\UserInterface;

interface User extends UserInterface
{
    /**
     * @return string
     */
    public function __toString();

    /**
     * @return string
     */
    public function getDisplayName();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return int
     */
    public function getId();
}
