<?php

namespace User;

use User\Factory\RegisterFactory;
use User\Factory\RegisterControllerFactory;
use User\Form\LoginForm;
use User\Form\RegisterForm;

return array(
    'router' => array(
        'routes' => array(
            'login' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/connexion',
                    'defaults' => array(
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'register',
                        'action'        => 'login',
                    ),
                ),
            ),
            'logout' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/deconnexion',
                    'defaults' => array(
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'register',
                        'action'        => 'logout',
                    ),
                ),
            ),
            'register' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/inscription',
                    'defaults' => array(
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'register',
                        'action'        => 'register',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'User\Controller\Register' => RegisterControllerFactory::class,
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Register'       => RegisterFactory::class,
        ),
    ),
    'form_elements' => array(
        'invokables' => array(
            'registerForm'  => RegisterForm::class,
            'loginForm'     => LoginForm::class,
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
            'zfcuser' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),

            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ),
            ),
        ),
    ),
);
