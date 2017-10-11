« [Routing](routing.md)
***
# Users
***
[Entity](users_entity.md) | [Repository](users_repositories.md) | [Data transfer objects](users_dto.md) | [Forms](users_forms.md) | CRUD
***
## CRUD
Now that we have our entities, forms and data transfer objects, it's time to tie it all together. To do this we will create services based on the MultiUserBundle's UserController. Each and every action you would usually write a controller for can now simply be defined as a service.

## UserController
The user controller is a generic controller in which you can inject a host of classes to make it do something. Sounds a bit abstract, doesn't it? We'll explain each parameter and what it does in our controller below.

### Form factory
This class should implement the `FormFactoryInterface` and will be used to create the form which we'll send in an other parameter. This should almost always be the `@form.factory` service, unless you want to make your own, of course!

### Router
The Symfony router lets you define creative URLs that you map to different areas of your application. In the UserController it will create a route from the named redirect route you will send in the last parameter. This should always be the `@router` service. 

This concludes the 'default' classes which we can just use from the Symfony framework.

### Form
This is the form you've created earlier. If you followed previous steps correctly it should implement the `FormTypeInterface` and will be usable in the user controller. 

### Handler
This class will handle the data sent by the form. The `MultiUserBundle` already has a set of default handlers which suffice in almost all cases. Services for these are as follows:

* `@multi_user.handler.create_user`
* `@multi_user.handler.update_user`
* `@multi_user.handler.delete_user`

If you want to use a custom handler to do some funky stuff like dispatching events you can always define your own. Just have a look at the default handlers, they're quite easy to understand.

Make sure your handler always matches the form you are injecting into the controller or the results might be unexpected! You wouldn't want to delete a user from an add form, wouldn't you?

### User repository
This is one of the repositories we've defined earlier, it shoud match the type of user you want to use.

### Redirect route
This one's optional. This is the route the controller will redirect to if everything succeeded. It can be both a named route or a hardcoded route.

### Complete example
```yaml
services:
  acme_bundle.admin.controller.create:
    class: SumoCoders\FrameworkMultiUserBundle\Controller\UserController
    arguments:
      - "@form.factory"
      - "@router"
      - "@session.flash_bag"
      - "@translator"
      - "MyProject\\UserBundle\\Form\AddAdminType"
      - "@multi_user.handler.create_user"
      - "@admin_repository"
      - "my_admin_overview"
```
```yaml
#routing.yml
add_admin_controller:
  defaults: { _controller: acme_bundle.admin.controller.create:baseAction}
  path:     /admin/create
```

So, we can now create and edit our users with the CRUD we've created, great! But how do we actually log in with these users? That's where the [user provider](user_provider.md) comes in to play!
***
[User provider](user_provider.md) »
