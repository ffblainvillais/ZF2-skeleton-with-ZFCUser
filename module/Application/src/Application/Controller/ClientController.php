<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use \Application\Entity\Client;

class ClientController extends AbstractActionController
{
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function indexAction()
    {
        $customers = $this->em->getRepository(Client::class)->findAll();

        $viewModel  = new ViewModel();
        $viewModel->setTemplate("application/client/index");
        $viewModel->setVariables(
            array(
                "customers" => $customers
            )
        );

        return $viewModel;
    }

    public function addCustomerAction()
    {
        $customerInfo = $this->params()->fromPost();

        $customer = new Client();

        $customer->setNom($customerInfo["name"]);
        $customer->setPrenom($customerInfo["firstname"]);
        $customer->setAdresse($customerInfo["address"]);
        $customer->setMail($customerInfo["mail"]);
        $customer->setTelephone($customerInfo["phone"]);

        $this->em->persist($customer);
        $this->em->flush();

        $this->flashMessenger()->addMessage('Le client est ajouté');

        $this->redirect()->toRoute('clients');

    }

    public function delCustomerAction()
    {
        $customerId = $this->params()->fromRoute('idClient');

        $customer = $this->em->getRepository(Client::class)->findOneBy(['id' => $customerId]);

        $this->em->remove($customer);
        $this->em->flush();

        $this->flashMessenger()->addMessage('Le client est supprimé');

        $this->redirect()->toRoute('clients');
    }

    public function modCustomerPageAction()
    {
        $customerId = $this->params()->fromRoute('idClient');

        $customer = $this->em->getRepository(Client::class)->findOneBy(['id' => $customerId]);

        $viewModel  = new ViewModel();
        $viewModel->setTemplate("application/client/modify-customer");
        $viewModel->setVariables(
            array(
                "customer" => $customer
            )
        );

        return $viewModel;

    }

    public function modCustomerAction()
    {
        $customerInfo   = $this->params()->fromPost();
        $customerId     = $this->params()->fromRoute('idClient');

        $customer       = $this->em->getRepository(Client::class)->findOneBy(['id' => $customerId]);

        $customer->setNom($customerInfo["name"]);
        $customer->setPrenom($customerInfo["firstname"]);
        $customer->setAdresse($customerInfo["address"]);
        $customer->setMail($customerInfo["mail"]);
        $customer->setTelephone($customerInfo["phone"]);

        $this->em->merge($customer);
        $this->em->flush();

        $this->redirect()->toRoute('clients');

    }
}
