<?php

namespace BwsShop\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UnregisteredCustomerController extends Controller
{
    public function indexAction()
    {
        return $this->render('BwsShopWebBundle:UnregisteredCustomer:index.html.twig');
    }
}
 