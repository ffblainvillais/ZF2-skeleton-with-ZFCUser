<?php

namespace Application\Factory ;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface ;
use \Application\Controller\ClientController;

class ClientControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();

        $em         = $realServiceLocator->get('Doctrine\ORM\EntityManager');

        return new ClientController(
            $em
        );
    }
}

