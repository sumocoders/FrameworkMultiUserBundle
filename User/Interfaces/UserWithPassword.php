<?php

namespace SumoCoders\FrameworkMultiUserBundle\User\Interfaces;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces\UserWithPasswordDataTransferObject;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserWithPassword extends UserInterface, PasswordReset
{
    /**
     * @return string
     */
    public function __toString();

    /**
     * @return string
     */
    public function getDisplayName();

    /**
     * @return int
     */
    public function getId();

    /**
     * @param UserWithPasswordDataTransferObject $data
     */
    public function change(UserWithPasswordDataTransferObject $data);

    /**
     * @return bool
     */
    public function hasPlainPassword();

    /**
     * @return string
     */
    public function getPlainPassword();

    /**
     * @param PasswordEncoderInterface $encoder
     */
    public function encodePassword(PasswordEncoderInterface $encoder);
}
