<?php

namespace SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Form;

use SumoCoders\FrameworkMultiUserBundle\User\UserInterface as UserEntityInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword
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
     * @var UserInterface
     */
    public $user;

    public static function forUser(UserEntityInterface $user)
    {
        $changePasswordTransferObject = new self();
        $changePasswordTransferObject->user = $user;

        return $changePasswordTransferObject;
    }
}
