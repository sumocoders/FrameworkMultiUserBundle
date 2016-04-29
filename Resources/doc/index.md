# Getting Started With FrameworkInMemoryBundle


## Installation

    composer require sumocoders/framework-multi-user-bundle

Enable the bundle in the kernel.

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    // ...
    $bundles = array(
        // ...
        new SumoCoders\FrameworkExampleBundle\SumoCodersFrameworkMultiUserBundle(),
    );
}
```

Add the routing:

```yaml
# app/config/routing.yml
sumo_coders_framework_multi_user:
    resource: "@SumoCodersFrameworkMultiUserBundle/Resources/config/routing.yml"
    prefix:   /
```

## Usage

To create a user provider, you need two services:

* A UserRepository implementing our
SumoCoders\FrameworkMultiUserBundle\User\UserRepository interface.
* An instance of the ObjectProvider getting the repository as argument

```yaml
# app/config/confing.yml
services:
  sumocoders.in_memory_user_repository:
    class: SumoCoders\FrameworkMultiUserBundle\User\InMemoryUserRepository
  sumocoders.in_memory_user_provider:
    class: SumoCoders\FrameworkMultiUserBundle\Security\ObjectUserProvider
    arguments:
      - "@sumocoders.in_memory_user_repository"
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

Don't forget to make the login url accessible by anonymous users

```yaml
# app/config/security.yml
security:
  access_control:
    - { path: ^/\w\w/login, role: IS_AUTHENTICATED_ANONYMOUSLY }
```
