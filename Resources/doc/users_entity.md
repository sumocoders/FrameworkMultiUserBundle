« [Routing](routing.md)
***
#Users
***
Entity | [Repository](users_repositories.md) | [Data transfer objects](users_dto.md) | [Forms](users_forms.md) | [CRUD](users_crud.md)
***
##Entity
For every type of user you want in your application, you're going to need an entity. An entity is basically a description of an object. Since every user you're going to want to define needs to implement the `SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User` interface it's a good idea to extend your users from the multi user bundle's `SumoCoders\FrameworkMultiUserBundle\User` class. In our documentation we will use an Admin and an Advisor as examples.

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
        parent::__construct($username, $plainPassword, $displayName, $email, $id, $token);
        
        $this->firstName = $firstName;
    }
    
    public function getRoles()
    {
        return [ 'ROLE_USER', 'ROLE_ADVISOR' ];
    }
    
    public function change(UserDataTransferObject $data)
    {
        parent::change($data);
        $this->firstName = $data->getFirstName();
    }
}
```

As you can see one extra property can make a hell of a change. You need to overwrite the constructor and change method to hold the extra property.

Now that we've defined our users, we need a way to store them! We do this with [repositories](users_repositories.md)

***
[Repository](users_repositories.md) »