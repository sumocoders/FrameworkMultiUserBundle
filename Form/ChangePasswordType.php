<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Form\ChangePassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChangePasswordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChangePassword::class,
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'change_password';
    }
}
