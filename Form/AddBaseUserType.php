<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\BaseUserDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\Form\Interfaces\FormWithDataTransferObject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddBaseUserType extends AbstractType implements FormWithDataTransferObject
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => $this->getDataTransferObjectClass(),
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'userName',
            TextType::class
        )->add(
            'displayName',
            TextType::class
        )->add(
            'email',
            EmailType::class
        )->add(
            'plainPassword',
            RepeatedType::class,
            [
                'type' => PasswordType::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'multi_user_form_add_user';
    }

    public static function getDataTransferObjectClass(): string
    {
        return BaseUserDataTransferObject::class;
    }
}
