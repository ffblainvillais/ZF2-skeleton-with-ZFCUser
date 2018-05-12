<?php

namespace User\Controller;

use User\Model\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

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

}
