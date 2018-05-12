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
            'name'      => 'firstname',
            'options'   => array(
                'label'     => 'Prenom',
            ),
            'attributes' => array(
                'type'          => 'text',
                'class'         => 'form-control',
                'placeholder'   => 'Prenom',
            ),
        ));

        $this->add(array(
            'name'      => 'lastname',
            'options'   => array(
                'label'     => 'Nom',
            ),
            'attributes' => array(
                'type'          => 'text',
                'class'         => 'form-control',
                'placeholder'   => 'Nom',
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
        return [
            'email' => array(
                'required' => true,
                'filters'  => [
                    ['name' => 'Zend\Filter\StringTrim'],
                ],
                'validators' => [
                    new \Zend\Validator\EmailAddress(),
                ],
            ),
            'password' => array(
                'required'      => true,
                'validators'    => array(
                    new \Zend\Validator\StringLength(
                        array('min' => 6)
                    ),
                ),
            ),
            'passwordVerify' => array(
                'required'      => true,
                'validators'    => array(
                    new \Zend\Validator\StringLength(
                        array('min' => 6)
                    ),
                    'name'    => new \Zend\Validator\Identical(
                        array('token' => 'password')
                    ),
                ),
            ),
        ];
        return array();
    }
}
