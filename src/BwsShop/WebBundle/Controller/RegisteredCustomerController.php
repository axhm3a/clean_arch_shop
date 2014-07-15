<?php

namespace BwsShop\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegisteredCustomerController extends Controller
{
    public function registeredAction(Request $request)
    {
        $interactor = $this->get('interactor.present_last_used_address');

        return $this->render(
            'BwsShopWebBundle:RegisteredCustomer:registered.html.twig',
            array(
                'display'  => $request->getSession()->get('display'),
                'invoice'  => $interactor->getInvoice($request->getSession()->get('customerId'))->address,
                'delivery' => $interactor->getDelivery($request->getSession()->get('customerId'))->address
            )
        );
    }
}
 