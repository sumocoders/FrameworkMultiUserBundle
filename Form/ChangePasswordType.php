<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\ChangePasswordDataTransferObject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'newPassword',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'options' => [
                        'attr' => [
                            'class' => 'input-lg',
                        ],
                    ],
                    'error_bubbling' => true,
                ]
            )->add(
                'submit',
                SubmitType::class,
                [
                    'label_format' => 'change.password.submit',
                    'attr' => [
                        'class' => 'btn-info pull-right',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => ChangePasswordDataTransferObject::class,
            ]
        );
    }

    public function getName()
    {
        return 'change_password';
    }
}
