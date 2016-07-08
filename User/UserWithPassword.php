<?php

namespace SumoCoders\FrameworkMultiUserBundle\User;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\UserDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class UserWithPassword implements User, PasswordReset
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @var string
     */
    protected $plainPassword;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $displayName;

    /**
     * @var PasswordResetToken
     */
    protected $passwordResetToken;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var int
     */
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

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return [ 'ROLE_USER' ];
    }

    /**
     * {@inheritDoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritDoc}
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param PasswordEncoderInterface $encoder
     */
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

    /**
     * {@inheritDoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritDoc}
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * {@inheritDoc}
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return $this->getDisplayName();
    }

    /**
     * {@inheritdoc}
     */
    public function clearPasswordResetToken()
    {
        $this->passwordResetToken = null;

        return $this;
    }

    /**
     * @return self
     */
    public function generatePasswordResetToken()
    {
        $this->passwordResetToken = PasswordResetToken::generate();

        return $this;
    }

    /**
     * @return string
     */
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

    /**
     * @param string $password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function hasPlainPassword()
    {
        return !empty($this->plainPassword);
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param UserDataTransferObject $data
     */
    public function change(
        UserDataTransferObject $data
    ) {
        $this->username = $data->userName;
        $this->plainPassword = $data->plainPassword;
        $this->displayName = $data->displayName;
        $this->email = $data->email;
    }
}
