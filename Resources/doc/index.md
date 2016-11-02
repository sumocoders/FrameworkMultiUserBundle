# Getting Started With FrameworkMultiUserBundle


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

Don't forget to make the login, request password and reset password urls accessible by anonymous users

```yaml
# app/config/security.yml
security:
  access_control:
    - { path: ^/\w\w/login, role: IS_AUTHENTICATED_ANONYMOUSLY }
    - { path: ^/\w\w/request-password-reset, role: IS_AUTHENTICATED_ANONYMOUSLY }
    - { path: ^/\w\w/reset-password, role: IS_AUTHENTICATED_ANONYMOUSLY }
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

To use the CLI commands the `@multi_user.user.repository` should be set.
The sumocoders:multiuser commands can create and delete a User Entity

The `sumocoders:mulituser:create` command requires
* username
* password
* displayname
* email

The `sumocoders:mulituser:delete` command requires a username

```yaml
services:
  multi_user.command.create_user:
    class: SumoCoders\FrameworkMultiUserBundle\Console\CreateUserCommand
    arguments:
      - "@multi_user.handler.create_user"
    tags:
      -  { name: "console.command" }

  multi_user.command.delete_user:
      class: SumoCoders\FrameworkMultiUserBundle\Console\DeleteUserCommand
      arguments:
        - "@multi_user.user.repository"
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

## User CRUD

For each CRUD action a controller service and route must be defined`

The services expects the following:
* a ContainerInterface
* a FormTypeInterface
* a Handler
* a UserRepository
* an optional redirect route

```yaml
services:
  multi_user.user.controller.create:
    class: SumoCoders\FrameworkMultiUserBundle\Controller\UserController
    arguments:
      - "@service_container"
      - "@multi_user_form_add_user"
      - "@multi_user.handler.create_user"
      - "@multi_user.user.repository"
      - "/nl"
```
```yaml
#routing.yml
  multi_user_controller:
    defaults: { _controller: multi_user.user.controller.create:baseAction}
    path:     /user/create
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
