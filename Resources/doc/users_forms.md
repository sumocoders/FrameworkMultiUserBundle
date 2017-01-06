« [Routing](routing.md)
***
#Users
***
[Entity](users_entity.md) | [Repository](users_repositories.md) | [Data transfer objects](users_dto.md) | Forms | [CRUD](users_crud.md)
***
##Forms
Every user needs a specific form for each base form you want to implement. Luckily, little configuration is required to get things going. 

4 forms are defined in `SumoCoders\FrameworkMultiUserBundle\Form`:

* AddUserType
* EditUserType
* ChangePasswordType
* RequestPasswordType

The first 2 forms are the most important since you will be extending these for each user. `ChangePasswordType` and `RequestPasswordType` are already implemented in the bundle itself.

In these examples I will show you what you need to do create an _add_ form for your users.

##The admin
```php
namespace AppBundle\Form;

use AppBundle\DataTransferObject\AdminDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\Form\AddUserType;

final class AddAdminType extends AddUserType
{
    public function getName()
    {
        return 'users_add_admin';
    }

    public function getDataTransferObjectClass()
    {
        return AdminDataTransferObject::class;
    }
}
```

As our Admin closely resembles a base user, all we need to do is define the name and the data transfer object class.

##The advisor
The same applies to our advisor but because we have an extra property, first name, we need also to add an extra field to our form.

```php
namespace AppBundle\Form;

use AppBundle\DataTransferObject\AdvisorDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\Form\AddUserType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

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
We have our forms, we have our entities, we have everything in between, let's tie everything together!
***
[CRUD](users_crud.md) »