<?php

namespace BwsShop\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegisteredCustomerController extends Controller
{
    public function registeredAction(Request $request)
    {
        return $this->render(
            'BwsShopWebBundle:RegisteredCustomer:registered.html.twig',
            array(
                'display' => $request->getSession()->get('display')
            )
        );
    }
}
 