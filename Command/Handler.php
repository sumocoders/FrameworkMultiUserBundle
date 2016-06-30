<?php

namespace SumoCoders\FrameworkMultiUserBundle\Command;

use SumoCoders\FrameworkMultiUserBundle\DataTransferObject\Form\UserInterface;

interface Handler
{
    public function handle(UserInterface $user);
}
