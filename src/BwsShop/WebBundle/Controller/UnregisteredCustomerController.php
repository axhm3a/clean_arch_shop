<?php

namespace BwsShop\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UnregisteredCustomerController extends Controller
{
    public function indexAction()
    {
        $paymentMethods   = $this->get('interactor.present_paymentmethods')->execute()->getPaymentMethods();
        $logisticPartners = $this->get('interactor.present_logisticpartners')->execute()->getLogisticPartners();

        return $this->render(
            'BwsShopWebBundle:UnregisteredCustomer:index.html.twig',
            array(
                'paymentMethods'   => $paymentMethods,
                'logisticPartners' => $logisticPartners
            )
        );
    }
}
 