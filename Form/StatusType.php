<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form;

use SumoCoders\FrameworkMultiUserBundle\ValueObject\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

final class StatusType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'status',
                'choice',
                [
                    'choices' => Status::getPossibleStatuses(),
                    'label' => false,
                    'expanded' => 'false',
                ]
            )
            ->setDataMapper($this)
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'SumoCoders\FrameworkMultiUserBundle\ValueObject\Status',
                'empty_data' => null,
            ]
        );
    }

    public function getName()
    {
        return 'user_status';
    }

    public function mapDataToForms($data, $forms)
    {
        $forms = iterator_to_array($forms);

        $forms['status']->setData($data ? (string) $data : null);
    }

    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);

        $data = Status::fromString($forms['status']->getData());
    }
}
