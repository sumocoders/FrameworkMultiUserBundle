<?php

namespace SumoCoders\FrameworkMultiUserBundle\User\Interfaces;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces\UserDataTransferObject;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface User extends UserInterface, PasswordReset, Blockable
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
     * @param UserDataTransferObject $data
     */
    public function change(UserDataTransferObject $data);

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
