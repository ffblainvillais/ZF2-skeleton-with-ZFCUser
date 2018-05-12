<?php

namespace User\View\Helper\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {

        $realServiceLocator = $serviceLocator->getServiceLocator();

        $userModel = $realServiceLocator->get('User');

        $viewHelper = new \User\View\Helper\User(
            $userModel
        );

        return $viewHelper;

    }
}
