<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\RequestPasswordDataTransferObject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                'userName',
                TextType::class,
                [
                    'label' => 'sumocoders.multiuserbundle.form.user',
                    'required' => true,
                ]
            )->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'sumocoders.multiuserbundle.form.request_password',
                ]
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RequestPasswordDataTransferObject::class,
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
