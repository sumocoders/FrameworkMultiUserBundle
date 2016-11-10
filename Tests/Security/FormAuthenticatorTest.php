<?php

namespace SumoCoders\FrameworkMultiUserBundle\Tests\Security;

use PHPUnit_Framework_TestCase;
use SumoCoders\FrameworkMultiUserBundle\Security\FormAuthenticator;
use SumoCoders\FrameworkMultiUserBundle\Security\FormCredentials;
use SumoCoders\FrameworkMultiUserBundle\Security\ObjectUserProvider;
use SumoCoders\FrameworkMultiUserBundle\User\InMemoryUserRepository;
use SumoCoders\FrameworkMultiUserBundle\User\UserRepositoryCollection;
use SumoCoders\FrameworkMultiUserBundle\Entity\User;
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

    public function setUp()
    {
        $this->router = $this->getMock(RouterInterface::class);
        $this->flashBag = $this->getMock(FlashBagInterface::class);
        $this->translator = $this->getMock(TranslatorInterface::class);
        $encoders['SumoCoders\FrameworkMultiUserBundle\Entity\User'] = [
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

    public function testFormAuthenticatorGetUser()
    {
        $userRepositoryCollection = new UserRepositoryCollection([new InMemoryUserRepository()]);
        $provider = new ObjectUserProvider($userRepositoryCollection);
        $user = $this->formAuthenticator->getUser($this->getCredentials(), $provider);

        $this->assertEquals($this->getUser(), $user);
    }

    public function testCheckCredentials()
    {
        $user = $this->getUser();
        $user->encodePassword(new PlaintextPasswordEncoder());
        $this->assertTrue(
            $this->formAuthenticator->checkCredentials($this->getCredentials($user->getSalt()), $user)
        );
    }

    /**
     * @expectedException Symfony\Component\Security\Core\Exception\BadCredentialsException
     */
    public function testBadCredentialsException()
    {
        $this->setExpectedException('Symfony\Component\Security\Core\Exception\BadCredentialsException');
        $this->formAuthenticator->checkCredentials(
            $this->getCredentials('wouter', 'wrongPassword'),
            $this->getUser()
        );
    }

    public function testOnAuthenticationSuccess()
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

    private function getCredentials($salt = 'zout', $username = 'wouter', $password = 'test')
    {
        $mock = $this->getMock(FormCredentials::class, [], [$username, $password . '{' . $salt . '}']);
        $mock->method('getUserName')->willReturn($username);
        $mock->method('getPlainPassword')->willReturn($password);

        return $mock;
    }

    private function getUser($username = 'wouter', $password = 'test', $displayName = 'Wouter Sioen', $email = 'wouter@example.dev', $id = 1)
    {
        return new User($username, $password, $displayName, $email, $id);
    }
}
