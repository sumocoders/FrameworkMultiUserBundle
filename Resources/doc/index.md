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

Add the logout route:

```yaml
#app/config/security.yml
security:
  firewalls:
    my_firewall:
      logout:
        path:   /%locale%/logout
        target: /
```

## Usage

To create a user provider, you need two services:

* A UserRepositoryCollection with UserRepositories implementing our
SumoCoders\FrameworkMultiUserBundle\User\UserRepository interface.
* An instance of the ObjectProvider getting the repository as argument

```yaml
# app/config/confing.yml
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

Don't forget to make the login url accessible by anonymous users

```yaml
# app/config/security.yml
security:
  access_control:
    - { path: ^/\w\w/login, role: IS_AUTHENTICATED_ANONYMOUSLY }
```

## Configuring redirect url's

Add this piece of yaml in your config file and add a line for every user that has
a custom redirect url. The default one is /.

```yaml
sumo_coders_framework_multi_user:
  redirect_routes:
    SumoCoders\FrameworkMultiUserBundle\User\User: sumocoders_frameworkexample_bootstrap_carousel
```

## User commands

The sumocoders:multiuser:xxx require the `multi_user.user_repository.collection` service

```yaml
services:
  multi_user.user_repository.collection:
    class: SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection
    arguments:
      - ["@user_repository1", "@user_repository2"]

  multi_user.handler.create_user:
      class: SumoCoders\FrameworkMultiUserBundle\Command\CreateUserHandler
      arguments:
        - "@multi_user.user_repository.collection"

  multi_user.handler.delete_user:
        class: SumoCoders\FrameworkMultiUserBundle\Command\DeleteUserHandler
        arguments:
          - "@multi_user.user_repository.collection"

  multi_user.command.create_user:
    class: SumoCoders\FrameworkMultiUserBundle\Command\CreateUserCommand
    arguments:
      - "@multi_user.user_repository.collection"
      - "@multi_user.handler.create_user"
    tags:
      -  { name: "console.command" }

  multi_user.command.delete_user:
      class: SumoCoders\FrameworkMultiUserBundle\Command\DeleteUserCommand
      arguments:
        - "@multi_user.user_repository.collection"
        - "@multi_user.handler.delete_user"
      tags:
        -  { name: "console.command" }
```

## User impersonation

Add a `switch_user` to the firewall to enable user impersonation

```yaml
security:
    firewalls:
        main:
          switch_user: { role: ROLE_ALLOWED_TO_SWITCH, parameter: _switch_user }
```

## Password reset

The password reset service needs two services

* the `@multi_user.user_repository.collection` service
* an event listener for PasswordResetTokenCreated

```yaml
services:
  multi_user.user_repository.collection:
    class: SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection
    arguments:
      - ["@user_repository1", "@user_repository2"]

  your_bundle.subscriber.on_password_reset_token_created:
    class: Your_Event_Subscriber_Class
    arguments:
      - "@mailer"
      - "@translator"
      - "@templating"
      - "%mailer_default_sender_email%"
    tags:
      - { name: "kernel.event_subscriber" }
```
