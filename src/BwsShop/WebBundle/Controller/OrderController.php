<?php

namespace BwsShop\WebBundle\Controller;

use Bws\Interactor\SubmitOrderAsUnregisteredCustomer;
use Bws\Interactor\SubmitOrderAsUnregisteredCustomerRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class OrderController extends Controller
{
    public function submitAction(Request $request)
    {
        $session                               = $request->getSession();
        $submitOrderRequest                    = new SubmitOrderAsUnregisteredCustomerRequest();
        $submitOrderRequest->invoiceFirstName  = $request->get('invoiceFirstName');
        $submitOrderRequest->invoiceLastName   = $request->get('invoiceLastName');
        $submitOrderRequest->invoiceStreet     = $request->get('invoiceStreetHouseNumber');
        $submitOrderRequest->invoiceZip        = $request->get('invoiceZip');
        $submitOrderRequest->invoiceCity       = $request->get('invoiceCity');
        $submitOrderRequest->emailAddress      = $request->get('email');
        $submitOrderRequest->deliveryFirstName = $request->get('deliveryFirstName');
        $submitOrderRequest->deliveryLastName  = $request->get('deliveryLastName');
        $submitOrderRequest->deliveryStreet    = $request->get('deliveryStreetHouseNumber');
        $submitOrderRequest->deliveryZip       = $request->get('deliveryZip');
        $submitOrderRequest->deliveryCity      = $request->get('deliveryCity');
        $submitOrderRequest->basketId          = $session->get('basketId', null);
        $submitOrderRequest->paymentMethodId   = $request->get('paymentMethodId');
        $submitOrderRequest->logisticPartnerId = $request->get('logisticPartnerId');
        $submitOrderRequest->registering       = $request->get('registering');

        $response = $this->get('interactor.submit_order_unregistered')->execute($submitOrderRequest);

        $session->set('orderId', $response->getOrderId());
        $session->set('basketId', 0);

        return $this->redirect($this->generateUrl('bws_shop_web_thanks'));
    }

    public function thanksAction(Request $request)
    {
        return $this->render(
            'BwsShopWebBundle:Order:thanks.html.twig',
            array('orderId' => $request->getSession()->get('orderId'))
        );
    }
}
 