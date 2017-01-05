« [Routing](routing.md)
***
#Users
***
[Entity](users_entity.md) | [Repository](users_repositories.md) | Data transfer objects | [Forms](users_forms.md) | [CRUD](users_crud.md)
***
##Data transfer objects
Data transfer objects are simply objects that carry data between processes. Nothing is done with this data, the point of a data transfer object is to simply translate a certain object to another.  

In our case it will be used in the communication between the forms which want to write their data to an object and our entity which will eventually hold the data the form received. Placing a data transfer object between the form and the entity allows us to not use setters.

##The admin
```
class AdminDataTransferObject extends UserDataTransferObject
{
    /**
     * @return Admin
     */
    public function getEntity()
    {
        if ($this->user) {
            $this->user->change($this);

            return $this->user;
        }

        return new Admin(
            $this->email,
            $this->plainPassword,
            $this->displayName,
            $this->email
        );
    }
}
```

This is all there is to it. Since the admin has the exact same properties as the base user all we need to do is make sure we return the correct entity.

##The advisor
```
class AdvisorDataTransferObject extends UserDataTransferObject
{
    /** @var string */
    public $firstName;

    /**
     * @param User $advisor
     *
     * @return self
     */
    public static function fromUser(User $advisor)
    {
        $advisorTransferObject = parent::fromUser($advisor);
        $advisorTransferObject->firstName = $advisor->getFirstName();

        return $advisorTransferObject;
    }

    /**
     * @return Advisor
     */
    public function getEntity()
    {
        if ($this->user) {
            $this->user->change($this);

            return $this->user;
        }

        return new Advisor(
            $this->email,
            $this->plainPassword,
            $this->displayName,
            $this->email,
            $this->firstName,
            $this->id
        );
    }
}
```

As you see, the extra property in the Advisor entity needs to be reflected in the data transfer object and has to be set in the `fromUser()` method.

Now that we have the means to communicate between the entity and the outside world, it's time to create some [forms](users_forms.md)!
***
[Forms](users_forms.md) »