<?php

namespace SumoCoders\FrameworkMultiUserBundle\Security;

use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;
use SumoCoders\FrameworkMultiUserBundle\User\BaseUserRepositoryCollection;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class ObjectUserProvider implements UserProviderInterface
{
    /** @var BaseUserRepositoryCollection */
    private $userRepositoryCollection;

    public function __construct(BaseUserRepositoryCollection $userRepositoryCollection)
    {
        $this->userRepositoryCollection = $userRepositoryCollection;
    }

    /**
     * @param string $username
     *
     * @return User
     *
     * @throws UsernameNotFoundException
     */
    public function loadUserByUsername($username): User
    {
        foreach ($this->userRepositoryCollection->all() as $repository) {
            $user = $repository->findByUsername($username);

            if ($user instanceof User) {
                return $user;
            }
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
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

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class): bool
    {
        return $this->userRepositoryCollection->supportsClass($class);
    }
}
