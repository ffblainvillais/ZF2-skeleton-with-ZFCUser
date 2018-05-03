<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegisterController extends AbstractActionController
{
    /* @var $registerForm \User\Form\RegisterForm */
    protected $registerForm;
    protected $registerModel;

    public function __construct($registerForm)
    {
        $this->registerForm = $registerForm;
    }

    public function registerAction()
    {
        if ($this->getRequest()->isPost()) {

            $registerParams = $this->params()->fromPost();
            $this->registerModel->register($registerParams);

        } else {

            $viewModel      = new ViewModel();

            $viewModel->setTemplate('user/register');
            $viewModel->setVariable("registerForm", $this->registerForm);

            return $viewModel;
        }
    }

}
