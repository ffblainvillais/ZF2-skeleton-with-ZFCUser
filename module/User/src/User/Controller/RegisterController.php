<?php

namespace User\Controller;

use User\Form\LoginForm;
use User\Form\RegisterForm;
use User\Model\Register;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegisterController extends AbstractActionController
{
    /* @var $registerForm \User\Form\RegisterForm */
    protected $registerForm;
    /* @var $registerModel \User\Model\Register */
    protected $registerModel;
    /* @var $loginForm \User\Form\LoginForm */
    protected $loginForm;

    public function __construct(RegisterForm $registerForm, Register $registerModel, LoginForm $loginForm)
    {
        $this->registerForm     = $registerForm;
        $this->loginForm        = $loginForm;
        $this->registerModel    = $registerModel;
    }

    public function loginAction()
    {
        if ($this->getRequest()->isPost()) {

            $loginParams    = $this->params()->fromPost();
            $login          = $this->registerModel->login($loginParams);

            if ($login) {
                return $this->redirect()->toRoute('home');
            }

            $this->flashMessenger()->addErrorMessage('Identifiant ou mot de passe erroné');
            return $this->redirect()->toRoute('login');

        } else {

            $viewModel      = new ViewModel();

            $viewModel->setTemplate('user/login');
            $viewModel->setVariable("loginForm", $this->loginForm);

            return $viewModel;
        }
    }

    public function registerAction()
    {
        if ($this->getRequest()->isPost()) {

            $registerParams = $this->params()->fromPost();
            $this->registerModel->register($registerParams);

            return $this->redirect()->toRoute('login');

        } else {

            $viewModel      = new ViewModel();

            $viewModel->setTemplate('user/register');
            $viewModel->setVariable("registerForm", $this->registerForm);

            return $viewModel;
        }
    }

}
