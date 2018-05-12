<?php

namespace User\View\Helper;

use User\Model\User as UserModel;
use Zend\View\Helper\AbstractHelper;


class User extends AbstractHelper
{

    protected $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function isConnected()
    {
        return $this->userModel->isConnected();
    }

    public function getDisplayName()
    {
        /* @var $user \User\Entity\User */
        $user = $this->userModel->getIdentity();

        return $user->getFirstname();
    }

    public function getIdentity()
    {
        return $this->userModel->getIdentity();
    }

    public function __invoke()
    {
        return $this;
    }
}
