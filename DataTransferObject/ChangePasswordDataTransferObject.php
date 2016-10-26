<?php

namespace SumoCoders\FrameworkMultiUserBundle\DataTransferObject;

use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserWithPassword;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePasswordDataTransferObject
{
    /**
     * @var string
     *
     * @Assert\Length(
     *     min = 6,
     *     minMessage = "sumocoders.multiuserbundle.form.length"
     * )
     */
    public $newPassword;

    /**
     * @var UserWithPassword
     */
    public $user;

    public static function forUser(UserWithPassword $user)
    {
        $changePasswordTransferObject = new self();
        $changePasswordTransferObject->user = $user;

        return $changePasswordTransferObject;
    }
}
