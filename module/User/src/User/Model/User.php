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

    public function isConnected()
    {
        $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {
            return true;
        }

        return false;
    }

    public function getIdentity()
    {
        $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {
            return $auth->getIdentity();
        }

        return false;
    }
}
