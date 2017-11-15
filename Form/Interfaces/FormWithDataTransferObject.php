<?php

namespace SumoCoders\FrameworkMultiUserBundle\Form\Interfaces;

use Symfony\Component\Form\FormTypeInterface;

interface FormWithDataTransferObject extends FormTypeInterface
{
    public static function getDataTransferObjectClass(): string;
}
