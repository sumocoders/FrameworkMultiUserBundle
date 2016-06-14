<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RequestPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'user',
                'text',
                [
                    'required' => true
                ]
            )->add('submit', 'submit', [
                'label' => 'sumocoders.multiuserbundle.form.request_password',
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'SumoCoders\FrameworkMultiUserBundle\Form\RequestPassword',
        ]);
    }

    public function getName()
    {
        return 'request_password';
    }
}
