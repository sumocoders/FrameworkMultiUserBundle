<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form;

class User
{
    /**
     * @var string
     */
    private $userName;

    /**
     * @var string
     */
    private $displayName;

    /**
     * User constructor.
     *
     * @param string|null $userName
     * @param string|null $displayName
     */
    public function __construct($userName = null, $displayName = null)
    {
        $this->userName = $userName;
        $this->displayName = $displayName;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
}
