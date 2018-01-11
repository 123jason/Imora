<?php

/// src/Oradt/OauthBundle/Security/User/WebserviceUserProvider.php

namespace Oradt\OauthBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityManager;

class WebserviceUserProvider implements UserProviderInterface
{

    private $em;

    /**
     * __construct
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager, $logger)
    {
        $this->em = $entityManager;
        $this->logger = $logger;
    }

    public function loadUserByUsername($username)
    {
        exit;
//        $request = $this->container->get('request');
//
//        //检测验证码
//        $validate = $request->get('validate');
//        //判断验证码是否正确
//        $sessvalidate = $session->get('validate');
//        if ($validate != $sessvalidate) {
//            $funlottery->AlertAndBack("验证码不正确，请重新填写！");
//        }
        // make a call to your webservice here
        $userData = $this->em->getRepository('OradtOauthBundle:LotUser')
            ->findOneBy(array('userName' => $username));

        // pretend it returns an array on success, false if there is no user
        if ($userData) {
            $password = $userData->getPassword();
            $salt = '';
            $roles = array('ROLE_USER');
            return new WebserviceUser($username, $password, $salt, $roles);
        }

        throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Acme\WebserviceUserBundle\Security\User\WebserviceUser';
    }

}