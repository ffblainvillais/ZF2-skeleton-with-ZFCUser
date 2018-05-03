<?php

namespace User\Model;

use User\Form\RegisterForm;
use ZfcUser\Entity\User;
use Zend\Crypt\Password\Bcrypt;
use DoctrineModule\Authentication\Adapter\ObjectRepository as DoctrineAdapter;
use Zend\Authentication\AuthenticationService;

class Register
{
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function login($loginParams)
    {
        $user = $this->_getUserByEmail($loginParams['email']);

        if ($user) {

            $passwordOk = $this->_checkUserPassword($loginParams['password'], $user);

            if ($passwordOk) {
                return $this->_connectUser($user);
            }
        }

        return false;
    }

    public function register($registerParams)
    {
        $formIsValid    = $this->_registerInformationsAreValid($registerParams);
        $userExist      = $this->_getUserByEmail($registerParams['email']);

        if ($formIsValid && !$userExist) {

            $user = new User();

            $user->setEmail($registerParams['email']);
            $user->setUsername($registerParams['username']);

            $bcrypt = new Bcrypt;
            $bcrypt->setCost(11);
            $user->setPassword($bcrypt->create($registerParams['password']));

            $this->em->persist($user);
            $this->em->flush();
        }
        
    }

    private function _connectUser(User $user)
    {
        $adapter = new DoctrineAdapter();

        $adapter->setIdentityValue($user->getId());
        $adapter->setCredentialValue($user->getPassword());
        $adapter->setOptions([
            'objectManager'      => $this->em,
            'identityClass'      => User::class,
            'identityProperty'   => 'id',
            'credentialProperty' => 'password',
        ]);

        $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {
            $auth->clearIdentity();
        }

        $result = $auth->authenticate($adapter);
        
        return $result->isValid();
    }

    private function _checkUserPassword($password, User $user)
    {
        $bcrypt     = new Bcrypt();
        $passwordOk = $bcrypt->verify($password, $user->getPassword());

        return $passwordOk;
    }

    private function _registerInformationsAreValid($registerInformation)
    {
        $form = new RegisterForm();

        $form->setData($registerInformation);
        
        if (!$form->isValid()) {
            return false;
        }

        return true;
    }

    private function _getUserByEmail($email)
    {
        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $email]);

        return $user;
    }

}
