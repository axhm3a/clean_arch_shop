<?php

namespace BwsShop\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AuthenticationController extends Controller
{
    public function indexAction()
    {
        return $this->render('BwsShopWebBundle:Authentication:index.html.twig');
    }
}
 