<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form;

use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword
{
    /**
     * @Assert\Length(
     *     min = 6,
     *     minMessage = "sumocoders.multiuserbundle.form.length"
     * )
     */
    public $newPassword;
}
