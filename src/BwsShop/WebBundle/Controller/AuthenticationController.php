<?php

namespace BwsShop\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class AuthenticationController extends Controller
{
    public function indexAction(Request $request)
    {
        if ($request->getSession()->get('total') == 0) {
            return $this->render('BwsShopWebBundle:Authentication:basket.empty.html.twig');
        } else {
            if ($request->get('login', false)) {
                $email    = $request->get('email');
                $password = $request->get('password');

                $loginInteractor = $this->get('interactor.login');
                $result          = $loginInteractor->execute($email, $password);

                if ($result->code == $result::SUCCESS) {
                    $request->getSession()->set('customerId', $result->customerId);
                    $request->getSession()->set('display', $result->display);
                    return $this->redirect($this->generateUrl('bws_shop_web_registered'));
                }
            }

            return $this->render('BwsShopWebBundle:Authentication:index.html.twig');
        }
    }

    public function logoutAction(Request $request)
    {
        $request->getSession()->set('display', null);
        $request->getSession()->set('customerId', null);
        return $this->redirect($this->generateUrl('bws_shop_web_authentication'));
    }
}
