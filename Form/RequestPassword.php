<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form;

use SumoCoders\FrameworkMultiUserBundle\User\UserInterface;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;

class RequestPassword
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var UserRepositoryCollection
     */
    private $userRepositoryCollection;

    /**
     * RequestPassword constructor.
     *
     * @param UserRepositoryCollection $userRepositoryCollection
     */
    public function __construct(UserRepositoryCollection $userRepositoryCollection)
    {
        $this->userRepositoryCollection = $userRepositoryCollection;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param $userName
     */
    public function setUser($userName)
    {
        $this->user = $this->userRepositoryCollection->findUserByUserName($userName);
    }
}
