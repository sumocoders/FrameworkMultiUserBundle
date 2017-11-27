<?php

namespace SumoCoders\FrameworkMultiUserBundle\Security;

use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;
use SumoCoders\FrameworkMultiUserBundle\User\BaseUserRepositoryCollection;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class ObjectUserEmailProvider implements UserProviderInterface
{
    /** @var BaseUserRepositoryCollection */
    private $userRepositoryCollection;

    public function __construct(BaseUserRepositoryCollection $userRepositoryCollection)
    {
        $this->userRepositoryCollection = $userRepositoryCollection;
    }

    /**
     * @param string $emailAddress
     *
     * @return User
     *
     * @throws UsernameNotFoundException
     */
    public function loadUserByUsername($emailAddress): User
    {
        foreach ($this->userRepositoryCollection->all() as $repository) {
            $user = $repository->findByEmailAddress($emailAddress);

            if ($user instanceof User) {
                return $user;
            }
        }

        // Since we are using the email as username we keep this exception since it is a part of symfony
        throw new UsernameNotFoundException(
            sprintf('Email "%s" does not exist.', $emailAddress)
        );
    }

    /**
     * @param UserInterface $user
     *
     * @return User
     *
     * @throws UnsupportedUserException
     */
    public function refreshUser(UserInterface $user): User
    {
        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getEmail());
    }

    public function supportsClass($class): bool
    {
        return $this->userRepositoryCollection->supportsClass($class);
    }
}
