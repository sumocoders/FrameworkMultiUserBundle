« [CRUD](users_crud.md)
***
#User provider

The user provider will do exactly as described. When requested, it will provide a user frome one of the repositories if it can find one.

To create a user provider, you'll need two services:

* A `UserRepositoryCollection` with the repositories we've created earlier.
* An instance of the `ObjectProvider` getting the repository as argument

```yaml
# app/config/config.yml
services:
  multi_user.user_repository.collection:
    class: SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection
    arguments:
      - ["@admin_repository", "@advisor_repository"]
  multi_user.user_provider:
    class: SumoCoders\FrameworkMultiUserBundle\Security\ObjectUserProvider
    arguments:
      - "@multi_user.user_repository.collection"
```

To use it, you have to define it and couple it to a firewall in your security.yml:

```yaml
# app/config/security.yml
security:
  providers:
    my_user_provider:
      id: multi_user.user_provider

  firewalls:
    my_firewall:
      provider: my_user_provider
      anonymous: ~
      ...
```
At this point you will be able to log in with the users you have in your database. Chances are you won't have any yet, though! This begs the question, how can we log in with a user to create a user without having a user? Sounds like it's time for a [CLI command](users_commands.md)!

***
[CLI command](users_commands.md) »