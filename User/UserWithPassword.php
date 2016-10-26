<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces\UserWithPasswordDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\UserWithPassword as UserWithPasswordInterface;

class UserWithPassword implements UserWithPasswordInterface
{
    /** @var string */
    protected $username;

    /** @var string */
    protected $salt;

    /** @var string */
    protected $plainPassword;

    /** @var string */
    protected $password;

    /** @var string */
    protected $displayName;

    /** @var PasswordResetToken */
    protected $passwordResetToken;

    /** @var string */
    protected $email;

    /** @var int */
    protected $id;

    /**
     * @param string $username
     * @param string $plainPassword
     * @param string $displayName
     * @param string $email
     * @param int $id
     * @param PasswordResetToken $token
     */
    public function __construct(
        $username,
        $plainPassword,
        $displayName,
        $email,
        $id = null,
        PasswordResetToken $token = null
    ) {
        $this->username = $username;
        $this->plainPassword = $plainPassword;
        $this->displayName = $displayName;
        $this->email = $email;
        $this->id = $id;

        if ($token) {
            $this->passwordResetToken = $token;
        }
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function encodePassword(PasswordEncoderInterface $encoder)
    {
        if (empty($this->plainPassword)) {
            return;
        }

        if (empty($this->salt)) {
            $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        }

        $this->password = $encoder->encodePassword($this->plainPassword, $this->salt);
        $this->eraseCredentials();
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function __toString()
    {
        return $this->getDisplayName();
    }

    public function clearPasswordResetToken()
    {
        $this->passwordResetToken = null;

        return $this;
    }

    public function generatePasswordResetToken()
    {
        $this->passwordResetToken = PasswordResetToken::generate();

        return $this;
    }

    public function getPasswordResetToken()
    {
        return $this->passwordResetToken;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function hasPlainPassword()
    {
        return !empty($this->plainPassword);
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function change(
        UserWithPasswordDataTransferObject $data
    ) {
        $this->username = $data->getUserName();
        $this->plainPassword = $data->getPlainPassword();
        $this->displayName = $data->getDisplayName();
        $this->email = $data->getEmail();
    }
}
