<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form;

use SumoCoders\FrameworkMultiUserBundle\User\UserInterface;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Symfony\Component\Validator\Constraints as Assert;

class RequestPassword
{
    /**
     * @var UserInterface
     */
    private $user;
    
    private $userRepositoryCollection;
    
    public function __construct(UserRepositoryCollection $userRepositoryCollection)
    {
        $this->userRepositoryCollection = $userRepositoryCollection;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($userName)
    {
        $this->user = $this->userRepositoryCollection->findUserByUserName($userName);
    }
}
