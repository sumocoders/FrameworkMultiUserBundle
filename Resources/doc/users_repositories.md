« [Routing](routing.md)
***
#Users
***
[Entity](users_entity.md) | Repository | [Data transfer objects](users_dto.md) | [Forms](users_forms.md) | [CRUD](users_crud.md)
***
##Repository
Every entity also requires it's own repository which extends `SumoCoders\FrameworkMultiUserBundle\User\UserRepository`. This is fairly simple to do because we only have to implement one method. These repositories can also contain custom methods for each entity.

Be sure to define these repositories as services, we'll need them in the next step!

###The admin

```
class AdminRepository extends UserRepository
{
    public function supportsClass($class)
    {
        return Admin::class === $class;
    }
}
```

###The advisor

```
class AdvisorRepository extends UserRepository
{
    public function supportsClass($class)
    {
        return Advisor::class === $class;
    }
}
```
As you can see nothing too exciting happens here. The `supportsClass()` method is used by the User Provider to know what repository it needs to use to fetch a certain entity.

We've now defined where we can find certain users, time to make communication possible!

***
[Data transfer objects](users_dto.md) »