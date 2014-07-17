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
        $submitOrderRequest->invoiceFirstName  = (string) $request->get('invoiceFirstName');
        $submitOrderRequest->invoiceLastName   = (string) $request->get('invoiceLastName');
        $submitOrderRequest->invoiceStreet     = (string) $request->get('invoiceStreetHouseNumber');
        $submitOrderRequest->invoiceZip        = (string) $request->get('invoiceZip');
        $submitOrderRequest->invoiceCity       = (string) $request->get('invoiceCity');
        $submitOrderRequest->emailAddress      = (string) $request->get('email');
        $submitOrderRequest->deliveryFirstName = (string) $request->get('deliveryFirstName');
        $submitOrderRequest->deliveryLastName  = (string) $request->get('deliveryLastName');
        $submitOrderRequest->deliveryStreet    = (string) $request->get('deliveryStreetHouseNumber');
        $submitOrderRequest->deliveryZip       = (string) $request->get('deliveryZip');
        $submitOrderRequest->deliveryCity      = (string) $request->get('deliveryCity');
        $submitOrderRequest->basketId          = $session->get('basketId', null);
        $submitOrderRequest->paymentMethodId   = (int) $request->get('paymentMethodId');
        $submitOrderRequest->logisticPartnerId = (int) $request->get('logisticPartnerId');
        $submitOrderRequest->registering       = (bool) $request->get('registering');

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
 