« [Routing](routing.md)
***
#Users
***
[Entity](users_entity.md) | [Forms](users_forms.md) | [Data transfer objects](users_dto.md) | CRUD | [Commands](users_commands.md)
***
##CRUD
Now that we have our entities, forms and data transfer objects, it's time to tie it all together. To do this we will create services based on the MultiUserBundle's UserController. Each and every action you would usually write a controller for can now simply be defined as a service.

##UserController
The user controller is a generic controller in which you can inject a host of classes to make it do something. Sounds a bit abstract, doesn't it? We'll explain each parameter and what it does in our controller below.

###Form factory
This class should implement the `FormFactoryInterface` and will be used to create the form which we'll send in an other parameter. This should almost always be the `@form.factory` service, unless you want to make your own, of course!

###Router
The Symfony router lets you define creative URLs that you map to different areas of your application. In the UserController it will create a route from the named redirect route you will send in the last parameter. This should always be the `@router` service. 

This concludes the 'default' classes which we can just use from the Symfony framework.

###Form
This is the form you've created earlier. If you followed previous steps correctly it should implement the `FormTypeInterface` and will be usable in the user controller. 

###Handler
This class will handle the data sent by the form. The `MultiUserBundle` already has a set of default handlers which suffice in almost all cases. Services for these are as follows:

* `@multi_user.handler.create_user`
* `@multi_user.handler.update_user`
* `@multi_user.handler.delete_user`

If you want to use a custom handler to do some funky stuff like dispatching events you can always define your own. Just have a look at the default handlers, they're quite easy to understand.

Make sure your handler always matches the form you are injecting into the controller or the results might be unexpected! You wouldn't want to delete a user from an add form, wouldn't you?

###User repository

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
***
[User provider](user_provider.md) »