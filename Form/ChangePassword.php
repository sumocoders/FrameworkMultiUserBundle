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
    protected $newPassword;

    public function getNewPassword()
    {
        return $this->newPassword;
    }

    public function setNewPassword($password)
    {
        $this->newPassword = $password;
    }
}
