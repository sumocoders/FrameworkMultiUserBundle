<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'newPassword',
                'repeated',
                [
                    'type' => 'password',
                    'required' => true,
                    'first_options' => ['label' => 'sumocoders.multiuserbundle.form.password'],
                    'second_options' => ['label' => 'sumocoders.multiuserbundle.form.repeat_password'],
                ]
            )->add('submit', 'submit', [
                'label' => 'sumocoders.multiuserbundle.form.change_password',
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'SumoCoders\FrameworkMultiUserBundle\Form\ChangePassword',
        ]);
    }

    public function getName()
    {
        return 'change_password';
    }
}
