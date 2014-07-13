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
        $session                               = $this->get('session');
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

        $response = $this->get('interactor.submit_order_unregistered')->execute($submitOrderRequest);

        $session->set('orderId', $response->getOrderId());
        $session->set('basketId', null);

        return $this->redirect($this->generateUrl('bws_shop_web_thanks'));
    }

    public function thanksAction()
    {
        return $this->render(
            'BwsShopWebBundle:Order:thanks.html.twig',
            array('orderId' => $this->get('session')->get('orderId'))
        );
    }
}
 