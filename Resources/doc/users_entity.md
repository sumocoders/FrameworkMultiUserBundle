« [Routing](routing.md)
***
#Users
***
Entity | [Forms](users_forms.md) | [Data transfer objects](users_dto.md) | [CRUD](users_crud.md) | [Commands](users_commands.md)
***
##Entity
For every type of user you want in your application, you're going to need an entity. An entity is basically a description of an object. Since every user you're going to want to define needs to implement the `SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User` interface it's a good idea to extend your users from the multi user bundle's `SumoCoders\FrameworkMultiUserBundle\User` class.

###The basics
In the example's we're going to use we've even create a base user that extends the base user. Why go through such madness, you ask? Well we at SumoCoders (and many others alike) use [Doctrine](http://www.doctrine-project.org/) as our ORM tool. While this is super useful and everyone should use it, we wanted to keep the multi user bundle as general as possible.

```php
/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"user" = "User", "admin" = "Admin", "advisor" = "Advisor"})
 */
abstract class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $username;
    
    ...
}
```

As you can see, all we do here is take the properties of the base user, repeat them and apply our mapping to it.  
Note the `@ORM\DiscriminatorMap()` tag in the class PHPDoc. This will be used to discriminate the users we will extend from this base user. This way we can have a combined table for the properties which both users have (such as `id`, `username` and so on) but also have seperate tables for the unique properties. More on this later.

###The admin

```
/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AdminRepository")
 */
class Admin extends User
{
    public function getRoles()
    {
        return [ 'ROLE_USER', 'ROLE_SUPER_ADMIN', 'ROLE_ALLOWED_TO_SWITCH' ];
    }
}
```

As you can see our admin user type has no extra properties compared to the base user. The only thing we need to do here is define the admin's roles.

###The advisor

In our example the advisor only has 1 extra property, a first name.

```
/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AdvisorRepository")
 */
class Advisor extends User
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $firstName;
    
    /**
     * @param string $username
     * @param string $plainPassword
     * @param string $displayName
     * @param string $email
     * @param string $firstName
     * @param int|null $id
     * @param PasswordResetToken|null $token
     */
    public function __construct(
        $username,
        $plainPassword,
        $displayName,
        $email,
        $firstName,
        $id = null,
        PasswordResetToken $token = null
    ) {
        $this->username = $username;
        $this->plainPassword = $plainPassword;
        $this->displayName = $displayName;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->id = $id;

        if ($token) {
            $this->passwordResetToken = $token;
        }
    }
    
    public function getRoles()
    {
        return [ 'ROLE_USER', 'ROLE_ADVISOR' ];
    }
    
    public function change(UserDataTransferObject $data)
    {
        $this->username = $data->getEmail();
        $this->plainPassword = $data->getPlainPassword();
        $this->displayName = $data->getDisplayName();
        $this->email = $data->getEmail();
        $this->firstName = $data->getFirstName();
    }
}
```

As you can see one extra property can make a hell of a change. You need to overwrite the constructor and change method to hold the extra property.

We've now defined our users, time to make communication possible!

***
[User provider](user_provider.md) »