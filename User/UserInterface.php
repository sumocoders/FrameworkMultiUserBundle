<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;

interface UserInterface extends BaseUserInterface
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
     * @return int
     */
    public function getId();
}
