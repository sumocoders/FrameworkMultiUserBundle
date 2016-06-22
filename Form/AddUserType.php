<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class AddUserType extends UserType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add(
            'password',
            'repeated',
            [
                'required' => 'required',
                'first_options' => [
                    'label' => 'sumocoders.multiuserbundle.form.password',
                ],
                'second_options' => [
                    'label' => 'sumocoders.multiuserbundle.form.repeated_password',
                ]
            ]
        );
    }

    public function getName()
    {
        return 'multi_user_form_add_user';
    }
}
