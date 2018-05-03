<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilterProviderInterface;

class RegisterForm extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct();

        $this->setAttribute('action', '#');

        $this->add(array(
            'name'      => 'username',
            'options'   => array(
                'label'     => 'Identifiant',
            ),
            'attributes' => array(
                'type'          => 'text',
                'class'         => 'form-control',
                'placeholder'   => 'Mon identifiant',
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 255,
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name'      => 'email',
            'options'   => array(
                'label'     => 'Email',
            ),
            'attributes' => array(
                'type'          => 'text',
                'class'         => 'form-control',
                'placeholder'   => 'name@mail.com',
            ),
        ));

        $this->add(array(
            'name'      => 'password',
            'type'      => 'password',
            'options'   => array(
                'label'     => 'Mot de passe',
            ),
            'attributes' => array(
                'type'          => 'password',
                'class'         => 'form-control',
                'placeholder'   => 'Mot de passe',
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name'      => 'passwordVerify',
            'type'      => 'password',
            'options'   => array(
                'label'     => 'Verification mot de passe',
            ),
            'attributes' => array(
                'type'          => 'password',
                'class'         => 'form-control',
                'placeholder'   => 'Mot de passe',

            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),
                array(
                    'name'    => 'Identical',
                    'options' => array(
                        'token'     => 'password',
                    ),
                ),
            ),
        ));

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel('Inscription')
            ->setAttributes(array(
                'type'  => 'submit',
                'class' => 'btn btn-lg btn-primary btn-block',
            ));

        $this->add($submitElement, array(
            'priority' => -100,
        ));
    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            /* Filtres et validateurs */
        );
    }
}
