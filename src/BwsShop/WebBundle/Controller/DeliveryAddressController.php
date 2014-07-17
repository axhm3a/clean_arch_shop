<?php

namespace BwsShop\WebBundle\Controller;

use Bws\Entity\Customer;
use Bws\Entity\DeliveryAddress;
use Bws\Interactor\DeliveryAddressSelectable;
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

        $customer  = $this->get('customer.repository')->find($customerId);
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
        $addressId  = $request->get('id');

        $result = $this->get('interactor.delivery_address_selectable')->execute($customerId, $addressId);

        switch ($result->code) {
            default:
            case $result::ADDRESS_NOT_FOUND:
            case $result::CUSTOMER_NOT_FOUND:
                $view = $this->view('address or customer not found', 500)->setTemplateVar('result');
                break;
            case $result::ADDRESS_DOES_NOT_BELONG_TO_GIVEN_CUSTOMER:
                $view = $this->view('forbidden', 403)->setTemplateVar('result');
                break;
            case $result::ADDRESS_IS_SELECTABLE:
                $view = $this->view('ok', 200)->setTemplateVar('result');
                break;
        }

        return $this->handleView($view);
    }
}
 