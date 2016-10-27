<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\UserDataTransferObject;
use SumoCoders\FrameworkMultiUserBundle\Form\Interfaces\FormWithDataTransferObject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserType extends AbstractType implements FormWithDataTransferObject
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => $this->getDataTransferObjectClass(),
            ]
        );
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'userName',
            'text',
            [
                'required' => 'required',
                'label' => 'sumocoders.multiuserbundle.form.userName',
            ]
        )->add(
            'displayName',
            'text',
            [
                'required' => 'required',
                'label' => 'sumocoders.multiuserbundle.form.displayName',
            ]
        )->add(
            'email',
            'email',
            [
                'required' => 'required',
                'label' => 'sumocoders.multiuserbundle.form.email',
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'multi_user_form_edit_user';
    }

    /**
     * @return string
     */
    public function getDataTransferObjectClass()
    {
        return UserDataTransferObject::class;
    }
}
