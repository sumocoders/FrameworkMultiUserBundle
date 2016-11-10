« [Routing](routing.md)
***
#Users
***
[Entity](users_entity.md) | Forms | [Data transfer objects](users_dto.md) | [CRUD](users_crud.md) | [Commands](users_commands.md)
***
##Forms
Every user needs a specific form for each base form you want to implement. Luckily, little configuration is required to get things going. In these examples I will show you what you need to do create an _add_ form for your users.

##The admin
```
final class AddAdminType extends AddUserType
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'users_add_admin';
    }

    /**
     * @return string
     */
    public function getDataTransferObjectClass()
    {
        return AdminDataTransferObject::class;
    }
}
```

As our Admin closely resembles a base user, all we need to do is define the name and the data transfer object class.

##The advisor
The same applies to our advisor but because we have an extra property, first name, we need also to add an extra field to our form.

```
final class AddAdvisorType extends AddUserType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('firstName', TextType::class);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'users_add_advisor';
    }

    /**
     * @return string
     */
    public function getDataTransferObjectClass()
    {
        return AdvisorDataTransferObject::class;
    }
}
```
***
[User provider](user_provider.md) »