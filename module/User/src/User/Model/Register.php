<?php

namespace User\Model;

use User\Form\RegisterForm;
use User\Entity\User;
use Zend\Crypt\Password\Bcrypt;
use DoctrineModule\Authentication\Adapter\ObjectRepository as DoctrineAdapter;
use Zend\Authentication\AuthenticationService;

class Register
{
    protected $em;
    protected $registerErrors = array(
        "emailAddressInvalidFormat" => "Adresse email incorrecte",
        "stringLengthTooShort"      => "Votre mot de passe doit contenir au moins 6 caractères",
        "notSame"                   => "Les mots de passe ne sont pas identiques",
    );

    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * Connect User if login information are good
     *
     * @param array $loginParams
     * @return bool
     */
    public function login($loginParams)
    {
        $user = $this->_getUserByLogin($loginParams['login']);

        if ($user) {

            $passwordOk = $this->_checkUserPassword($loginParams['password'], $user);

            if ($passwordOk) {
                return $this->_connectUser($user);
            }
        }

        return false;
    }

    /**
     * Disconnected User
     */
    public function logout()
    {
        $auth = new AuthenticationService();
        $auth->clearIdentity();
    }

    /**
     * Create new User if $registerParams are valid, else return errors
     *
     * @param array $registerParams
     * @return array
     */
    public function register($registerParams)
    {
        $formIsValid    = $this->_registerInformationsAreValid($registerParams);
        $userExist      = $this->_getUserByLogin($registerParams['email']);

        if ($formIsValid && !$userExist) {

            $user = new User();

            $user->setLogin($registerParams['email']);
            $user->setEmail($registerParams['email']);
            $user->setFirstname($registerParams['firstname']);
            $user->setLastname($registerParams['lastname']);

            $bcrypt = new Bcrypt;
            $bcrypt->setCost(11);
            $user->setPassword($bcrypt->create($registerParams['password']));

            $this->em->persist($user);
            $this->em->flush();

        } elseif (!$formIsValid) {
            return $this->_getFormErrorsMapped($registerParams);
        }
        
    }

    /**
     * Connect a User
     *
     * @param User $user
     * @return bool
     */
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

    /**
     * Check if password provided is the good User's password
     *
     * @param string $password
     * @param User $user
     * @return bool
     */
    private function _checkUserPassword($password, User $user)
    {
        $bcrypt     = new Bcrypt();
        $passwordOk = $bcrypt->verify($password, $user->getPassword());

        return $passwordOk;
    }

    /**
     * Return true if register information are valid, else return false
     *
     * @param array $registerInformation
     * @return bool
     */
    private function _registerInformationsAreValid($registerInformation)
    {
        $form = new RegisterForm();

        $form->setData($registerInformation);
        
        if (!$form->isValid()) {
            return false;
        }

        return true;
    }

    /**
     * Return custom form errors messages
     *
     * @param array $registerInformation
     * @return array
     */
    private function _getFormErrorsMapped($registerInformation)
    {
        $registerErrors     = $this->_getFormErrors($registerInformation);
        $errorsMapped       = array();

        foreach ($registerErrors as $filedWithErrors) {

            foreach ($filedWithErrors as $name => $value) {

                $currentError = $this->registerErrors[$name];

                if (!in_array($currentError, $errorsMapped)) {
                    $errorsMapped[] = $this->registerErrors[$name];
                }
            }
        }

        return $errorsMapped;
    }

    /**
     * Return Zend form errors messages
     *
     * @param array $registerInformation
     * @return array|\Traversable
     */
    private function _getFormErrors($registerInformation)
    {
        $form = new RegisterForm();

        $form->setData($registerInformation);

        if (!$form->isValid()) {
            return $form->getMessages();
        }
    }

    /**
     * Return User by his login
     *
     * @param string $login
     * @return mixed
     */
    private function _getUserByLogin($login)
    {
        $user = $this->em->getRepository(User::class)->findOneBy(['login' => $login]);

        return $user;
    }

}
