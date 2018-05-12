<?php

namespace User\Controller;

use User\Model\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;

class IndexController extends AbstractActionController
{
    /* @var $userModel \User\Model\User */
    protected $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel     = $userModel;
    }

    public function indexAction()
    {
        $viewModel      = new ViewModel();

        $viewModel->setTemplate('user/index');

        return $viewModel;
    }

    protected function attachDefaultListeners()
    {
        parent::attachDefaultListeners();

        $events = $this->getEventManager();
        $events->attach('dispatch', [$this, 'preDispatch'], 100);
    }

    public function preDispatch(MvcEvent $e)
    {
        if (!$this->userModel->isConnected()) {
            return $this->redirect()->toRoute('login');
        }
    }

}
