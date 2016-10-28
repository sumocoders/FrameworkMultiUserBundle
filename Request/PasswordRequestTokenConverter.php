<?php

namespace SumoCoders\FrameworkMultiUserBundle\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use SumoCoders\FrameworkMultiUserBundle\Security\PasswordResetToken;
use Symfony\Component\HttpFoundation\Request;

final class PasswordRequestTokenConverter implements ParamConverterInterface
{
    public function apply(Request $request, ParamConverter $configuration)
    {
        $token = new PasswordResetToken($request->attributes->get('token'));
        $request->attributes->set('token', $token);

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        return PasswordResetToken::class === $configuration->getClass();
    }
}
