<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\BaseUserDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\Entity\UserRole;
use SumoCoders\FrameworkMultiUserBundle\Form\Interfaces\FormWithDataTransferObject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

class AddBaseUserType extends AbstractType implements FormWithDataTransferObject
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

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
        )->add(
            'roles',
            EntityType::class,
            [
                'attr' => [
                    'class' => 'select2',
                ],
                'class' => UserRole::class,
                'choice_label' => function (UserRole $userRole) {
                    return $this->translator->trans($userRole);
                },
                'required' => false,
                'multiple' => true,
                'placeholder' => '',
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
