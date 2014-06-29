<?php

namespace BwsShop\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class AuthenticationController extends Controller
{
    public function indexAction()
    {
        $session = new Session();
        if ($session->get('total') == 0) {
            return $this->render('BwsShopWebBundle:Authentication:basket.empty.html.twig');
        } else {
            return $this->render('BwsShopWebBundle:Authentication:index.html.twig');
        }
    }
}
 