<?php

namespace BwsShop\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends Controller
{
    public function submitAction(Request $request)
    {
        return $this->redirect($this->generateUrl('bws_shop_web_thanks'));
    }

    public function thanksAction()
    {
        return $this->render('BwsShopWebBundle:Order:thanks.html.twig');
    }
}
 