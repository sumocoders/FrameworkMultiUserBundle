<?php

namespace SumoCoders\FrameworkMultiUserBundle\DataTransferObject;

use Symfony\Component\Validator\Constraints as Assert;

class RequestPasswordDataTransferObject
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public $userName;
}
