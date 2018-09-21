<?php

namespace SumoCoders\FrameworkMultiUserBundle\Security;

use SumoCoders\FrameworkMultiUserBundle\Traits\SoftDeletable;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class ObjectUserProvider implements UserProviderInterface
{
    /** @var UserRepositoryCollection */
    private $userRepositoryCollection;

    /**
     * @param UserRepositoryCollection $userRepositoryCollection
     */
    public function __construct(UserRepositoryCollection $userRepositoryCollection)
    {
        $this->userRepositoryCollection = $userRepositoryCollection;
    }

    public function loadUserByUsername($username)
    {
        foreach ($this->userRepositoryCollection->all() as $repository) {
            $user = $repository->findByUsername($username);

            if ($user instanceof User) {
                if (in_array(SoftDeletable::class, $this->getEntityTraits($user))
                    && $user->isDeleted()
                ) {
                    continue;
                }

                return $user;
            }
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }

    private function getEntityTraits($class, $autoload = true)
    {
        $traits = [];

        // Get traits of all parent classes
        do {
            $traits = array_merge(class_uses($class, $autoload), $traits);
        } while ($class = get_parent_class($class));

        // Get traits of all parent traits
        $traitsToSearch = $traits;
        while (!empty($traitsToSearch)) {
            $newTraits = class_uses(array_pop($traitsToSearch), $autoload);
            $traits = array_merge($newTraits, $traits);
            $traitsToSearch = array_merge($newTraits, $traitsToSearch);
        };

        foreach ($traits as $trait => $same) {
            $traits = array_merge(class_uses($trait, $autoload), $traits);
        }

        return array_unique($traits);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $this->userRepositoryCollection->supportsClass($class);
    }
}
