<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'SumoCoders\FrameworkMultiUserBundle\Form\User'
        ]);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'username',
            'text',
            [
                'required' => 'required',
                'label' => 'sumocoders.multiuserbundle.form.userName'
            ]
        )->add(
            'displayName',
            'text',
            [
                'required' => 'required',
                'label' => 'sumocoders.multiuserbundle.form.displayName'
            ]
        );
    }

    public function getName()
    {
        return 'multi_user_form_user';
    }
}
