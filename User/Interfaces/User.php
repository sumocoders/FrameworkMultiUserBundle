<?php

namespace SumoCoders\FrameworkMultiUserBundle\User\Interfaces;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces\UserDataTransferObject;

interface User
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string[]
     */
    public function getRoles();

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @return string
     */
    public function getDisplayName();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param UserDataTransferObject $data
     */
    public function change(UserDataTransferObject $data);

    /**
     * @return string
     */
    public function __toString();
}
