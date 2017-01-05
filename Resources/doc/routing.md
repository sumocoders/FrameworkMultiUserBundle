« [Installation](installation.md)
***
#Routing
The multiuser bundle already has all necessary routes predefined.

- /login
- /logout
- /reset-password/{token}
- /request-password-reset

you can include them in `app/config/routing.yml` as follows:

```yaml
# app/config/routing.yml
sumo_coders_framework_multi_user:
    resource: "@SumoCodersFrameworkMultiUserBundle/Resources/config/routing.yml"
    prefix:   /
```

If you want to make your own routes you can always overwrite them, just make sure you use the same names. You can always just make your own from scratch, of course.

##Configure the logout route

The multiuser bundle is partially built on top of Symfony's built in mechanisms. Since you don't need any special code to log out, you have to let Symfony know you want to logout when going to a certain url. You can do this by setting the logout route of your firewall in `app/config/security.yml`

```yaml
#app/config/security.yml
security:
  firewalls:
    my_firewall:
      logout:
        path:   /%locale%/logout
        target: /
```

Note the logout path matches the route we set earlier.

##Keep your guard up
We need to let our application know who the guard at our front door is. In the case of the multiuser bundle, the guard is `sumocoders.form_authenticator`. This class will handle the authentication of anyone who tries to enter the application.

```yaml
#app/config/security.yml
security:
  firewalls:
    my_firewall:
      guard:
        authenticators:
          - sumocoders.form_authenticator
```

##Authentication
Don't forget to make the login, request password and reset password urls accessible by anonymous users. Otherwise, you won't be able to login without being logged in, weird right?

```yaml
# app/config/security.yml
security:
  access_control:
    - { path: ^/\w\w/login, role: IS_AUTHENTICATED_ANONYMOUSLY }
    - { path: ^/\w\w/request-password-reset, role: IS_AUTHENTICATED_ANONYMOUSLY }
    - { path: ^/\w\w/reset-password, role: IS_AUTHENTICATED_ANONYMOUSLY }
```
***
[Users, users everywhere!](users_entity.md) »