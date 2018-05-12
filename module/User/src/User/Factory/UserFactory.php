<?php

namespace User\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em     = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $model  = new \User\Model\User(
            $em
        );

        return $model;
    }
}
