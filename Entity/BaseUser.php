<?php

namespace SumoCoders\FrameworkMultiUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Serializable;
use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Interfaces\UserDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;
use SumoCoders\FrameworkMultiUserBundle\ValueObject\Status;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="SumoCoders\FrameworkMultiUserBundle\User\DoctrineBaseUserRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 */
class BaseUser implements User, Serializable, EquatableInterface
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $salt;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $displayName;

    /**
     * @var PasswordResetToken
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $passwordResetToken;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @var Status
     *
     * @ORM\Column(type="user_status")
     */
    protected $status;

    /**
     * @var string
     */
    protected $plainPassword;

    /**
     * @param string $username
     * @param string $plainPassword
     * @param string $displayName
     * @param string $email
     * @param int $id
     * @param PasswordResetToken $token
     */
    public function __construct(
        string $username,
        string $plainPassword,
        string $displayName,
        string $email,
        int $id = null,
        PasswordResetToken $token = null
    ) {
        $this->username = $username;
        $this->plainPassword = $plainPassword;
        $this->displayName = $displayName;
        $this->email = $email;
        $this->id = $id;

        // set the default status to active
        $this->status = Status::active();

        if ($token) {
            $this->passwordResetToken = $token;
        }
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function encodePassword(PasswordEncoderInterface $encoder): void
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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function __toString(): string
    {
        return $this->getDisplayName();
    }

    public function clearPasswordResetToken(): self
    {
        $this->passwordResetToken = null;

        return $this;
    }

    public function generatePasswordResetToken(): self
    {
        $this->passwordResetToken = PasswordResetToken::generate();

        return $this;
    }

    public function getPasswordResetToken(): ?PasswordResetToken
    {
        return $this->passwordResetToken;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPassword(string $password): self
    {
        $this->plainPassword = $password;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function hasPlainPassword(): bool
    {
        return !empty($this->plainPassword);
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function change(UserDataTransferObject $data): void
    {
        $this->username = $data->getUserName();
        $this->plainPassword = $data->getPlainPassword();
        $this->displayName = $data->getDisplayName();
        $this->email = $data->getEmail();
    }

    public function toggleBlock(): void
    {
        if ((string) $this->status === Status::BLOCKED) {
            $this->status = Status::active();

            return;
        }

        $this->status = Status::blocked();
    }

    public function isBlocked(): bool
    {
        return $this->status->isBlocked();
    }

    public function canSwitchTo(BaseUser $user): bool
    {
        return false;
    }

    public function serialize(): string
    {
        return serialize(
            [
                $this->id,
                $this->username,
                $this->password,
                $this->salt,
            ]
        );
    }

    public function unserialize($serialized): void
    {
        [$this->id, $this->username, $this->password, $this->salt] = unserialize($serialized);
    }

    public function isEqualTo(UserInterface $user): bool
    {
        return $user->getUsername() === $this->getUsername();
    }
}
