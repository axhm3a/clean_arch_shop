<?php

namespace BwsShop\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegisteredCustomerController extends Controller
{
    public function registeredAction(Request $request)
    {
        $interactor       = $this->get('interactor.present_last_used_address');
        $paymentMethods   = $this->get('interactor.present_paymentmethods')->execute()->getPaymentMethods();
        $logisticPartners = $this->get('interactor.present_logisticpartners')->execute()->getLogisticPartners();

        return $this->render(
            'BwsShopWebBundle:RegisteredCustomer:registered.html.twig',
            array(
                'display'          => $request->getSession()->get('display'),
                'invoice'          => $interactor->getInvoice($request->getSession()->get('customerId'))->address,
                'delivery'         => $interactor->getDelivery($request->getSession()->get('customerId'))->address,
                'paymentMethods'   => $paymentMethods,
                'logisticPartners' => $logisticPartners
            )
        );
    }
}
 