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
            'data_class' => $this->getDataTransferObjectClass(),
        ]);
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

    public function getName()
    {
        return 'multi_user_form_user';
    }

    /**
     * @return string
     */
    public function getDataTransferObjectClass()
    {
        return 'SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Form\BaseUser';
    }
}
