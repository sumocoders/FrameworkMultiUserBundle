<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RequestPasswordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'user',
                'text',
                [
                    'label' => 'sumocoders.multiuserbundle.form.user',
                    'required' => true,
                ]
            )->add('submit', 'submit', [
                'label' => 'sumocoders.multiuserbundle.form.request_password',
            ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RequestPassword::class,
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'request_password';
    }
}
