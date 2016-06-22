<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form;

class AddUser extends User
{
    /**
     * @var string
     */
    private $password;

    /**
     * User constructor.
     *
     * @param string|null $userName
     * @param string|null $displayName
     * @param string|null $password
     */
    public function __construct($userName = null, $displayName = null, $password = null)
    {
        parent::__construct($userName, $displayName);

        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}
