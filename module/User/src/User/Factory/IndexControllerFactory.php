<?php

namespace User\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface ;
use \User\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $userModel          = $realServiceLocator->get('User');

        return new IndexController(
            $userModel
        );
    }
}

