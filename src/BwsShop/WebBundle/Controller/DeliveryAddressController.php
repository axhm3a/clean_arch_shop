<?php

namespace BwsShop\WebBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class DeliveryAddressController extends FOSRestController
{
    /**
     * @View
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $customerId = $request->getSession()->get('customerId');

        $customer = $this->get('customer.repository')->find($customerId);
        $addresses = $this->get('deliveryaddress.repository')->findBy(array('customer' => $customer));

        $view = $this
            ->view($addresses, 200)
            ->setTemplate('BwsShopWebBundle:Basket:list.html.twig')
            ->setTemplateVar('addresses');

        return $this->handleView($view);
    }

    /**
     * @View
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function selectAction(Request $request)
    {
        $customerId = $request->getSession()->get('customerId');
        $addressId = $request->get('id');

        $customer = $this->get('customer.repository')->find($customerId);
        $address = $this->get('deliveryaddress.repository')->find($addressId);

        $request->getSession()->set('selectedDeliveryAddressId', $addressId);

        $view = $this
            ->view('ok', 200)
            ->setTemplateVar('result')
        ;

        return $this->handleView($view);
    }
}
 