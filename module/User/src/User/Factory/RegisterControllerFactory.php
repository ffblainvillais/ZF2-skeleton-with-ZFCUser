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
        $loginForm          = $realServiceLocator->get('FormElementManager')->get('loginForm');
        $registerModel      = $realServiceLocator->get('Register');

        return new RegisterController(
            $registerForm,
            $registerModel,
            $loginForm
        );
    }
}

