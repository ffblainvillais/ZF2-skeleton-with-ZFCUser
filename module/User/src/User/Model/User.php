<?php

namespace User\Model;

use User\Entity\User as UserEntity;
use Zend\Authentication\AuthenticationService;

class User
{
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * Return true if one User is connected
     *
     * @return bool
     */
    public function isConnected()
    {
        $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {
            return true;
        }

        return false;
    }

    /**
     * Return User if one is connected
     *
     * @return bool|mixed|null
     */
    public function getIdentity()
    {
        $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {
            return $auth->getIdentity();
        }

        return false;
    }
}
