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

    /**
     * Return true if a User is connected
     *
     * @return bool
     */
    public function isConnected()
    {
        return $this->userModel->isConnected();
    }

    /**
     * Return firstname of User if connected
     *
     * @return null|string
     */
    public function getDisplayName()
    {
        /* @var $user \User\Entity\User */
        $user = $this->userModel->getIdentity();

        if ($user) {
            return $user->getFirstname();
        }

        return null;
    }

    /**
     * Return entity User if one connected
     *
     * @return bool|mixed|null
     */
    public function getIdentity()
    {
        return $this->userModel->getIdentity();
    }

    public function __invoke()
    {
        return $this;
    }
}
