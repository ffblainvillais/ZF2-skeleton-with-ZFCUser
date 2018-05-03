<?php

namespace User\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface ;
use \User\Controller\RegisterController;

class RegisterControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $registerForm       = $realServiceLocator->get('FormElementManager')->get('registerForm');

        return new RegisterController(
            $registerForm
        );
    }
}

