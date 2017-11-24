<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Security;

use PHPUnit_Framework_TestCase;
use SumoCoders\FrameworkMultiUserBundle\Security\FormAuthenticator;
use SumoCoders\FrameworkMultiUserBundle\Security\FormCredentials;
use SumoCoders\FrameworkMultiUserBundle\Security\ObjectUserProvider;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryBaseUserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\BaseUserRepositoryCollection;
use SumoCoders\FrameworkMultiUserBundle\Entity\BaseUser;
use SumoCoders\FrameworkMultiUserBundle\User\Interfaces\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Translation\TranslatorInterface;

class FormAuthenticatorTest extends PHPUnit_Framework_TestCase
{
    private $formAuthenticator;
    private $router;
    private $flashBag;
    private $translator;

    public function setUp(): void
    {
        $this->router = $this->getMockBuilder(RouterInterface::class)->getMock();
        $this->flashBag = $this->getMockBuilder(FlashBagInterface::class)->getMock();
        $this->translator = $this->getMockBuilder(TranslatorInterface::class)->getMock();
        $encoders[ 'SumoCoders\FrameworkMultiUserBundle\Entity\BaseUser' ] = [
            'class' => 'Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder',
            'arguments' => [12],
        ];
        $encoder = new UserPasswordEncoder(new EncoderFactory($encoders));
        $redirectRoutes = [];
        $this->formAuthenticator = new FormAuthenticator(
            $encoder,
            $this->router,
            $this->flashBag,
            $this->translator,
            $redirectRoutes
        );
    }

    public function testFormAuthenticatorGetUser(): void
    {
        $userRepositoryCollection = new BaseUserRepositoryCollection(
            [
                new InMemoryBaseUserRepository(
                    new EncoderFactory([BaseUser::class => new PlaintextPasswordEncoder()])
                ),
            ]
        );
        $provider = new ObjectUserProvider($userRepositoryCollection);
        $user = $this->formAuthenticator->getUser($this->getCredentials(), $provider);

        $this->assertEquals($this->getUser()->getId(), $user->getId());
        $this->assertEquals($this->getUser()->getUsername(), $user->getUsername());
        $this->assertEquals($this->getUser()->getEmail(), $user->getEmail());
    }

    public function testCheckCredentials(): void
    {
        $user = $this->getUser();
        $user->encodePassword(new PlaintextPasswordEncoder());
        $this->assertTrue(
            $this->formAuthenticator->checkCredentials($this->getCredentials(), $user)
        );
    }

    /**
     * @expectedException Symfony\Component\Security\Core\Exception\BadCredentialsException
     */
    public function testBadCredentialsException(): void
    {
        $this->expectException('Symfony\Component\Security\Core\Exception\BadCredentialsException');
        $this->formAuthenticator->checkCredentials(
            $this->getCredentials('wouter', 'wrongPassword'),
            $this->getUser()
        );
    }

    public function testOnAuthenticationSuccess(): void
    {
        $request = new Request();
        $providerKey = 'main';
        $token = new UsernamePasswordToken('wouter', null, $providerKey, ['ROLE_USER']);

        $session = new Session(new MockArraySessionStorage());
        $session->set('_security_'.$providerKey, serialize($token));
        $session->set('_security.'.$providerKey.'.target_path', '/randomURL');
        $session->save();
        $request->setSession($session);

        $this->formAuthenticator->onAuthenticationSuccess($request, $token, $providerKey);
    }

    private function getCredentials($username = 'wouter', $password = 'test'): FormCredentials
    {
        $mock = $this->getMockBuilder(FormCredentials::class)->disableOriginalConstructor()->getMock();
        $mock->method('getUserName')->willReturn($username);
        $mock->method('getPlainPassword')->willReturn($password);

        return $mock;
    }

    private function getUser(): User
    {
        $inMemoryBaseUserRepository = new InMemoryBaseUserRepository(
            new EncoderFactory([BaseUser::class => new PlaintextPasswordEncoder()])
        );

        return $inMemoryBaseUserRepository->find(1);
    }
}
