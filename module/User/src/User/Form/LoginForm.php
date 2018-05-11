<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilterProviderInterface;

class LoginForm extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name'      => 'login',
            'options'   => array(
                'label'     => 'Identifiant',
            ),
            'attributes' => array(
                'type'          => 'text',
                'class'         => 'form-control',
                'placeholder'   => 'Mon email',
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

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel('Connexion')
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
