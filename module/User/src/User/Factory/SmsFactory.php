<?php

namespace Sms\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SmsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {

        $config    = $serviceLocator->get('Config');

        $model = new \Sms\Model\Sms($config);

        return $model;
    }
}
