« [back to overview](index.md)
#User provider

To create a user provider, you need two services:

* A UserRepositoryCollection with UserRepositories implementing our
SumoCoders\FrameworkMultiUserBundle\User\UserRepository interface.
* An instance of the ObjectProvider getting the repository as argument

```yaml
# app/config/config.yml
services:
  multi_user.user_repository.collection:
    class: SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection
    arguments:
      - ["@user_repository1", "@user_repository2"]
  sumocoders.in_memory_user_provider:
    class: SumoCoders\FrameworkMultiUserBundle\Security\ObjectUserProvider
    arguments:
      - "@multi_user.user_repository.collection"
```

To use it, you have to define it and couple it to a firewall in your security.yml:

```yaml
# app/config/security.yml
security:
  providers:
    my_in_memory_provider:
      id: sumocoders.in_memory_user_provider

  firewalls:
    my_firewall:
      provider: my_in_memory_provider
      anonymous: ~
      ...
```

