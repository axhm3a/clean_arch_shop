<?php

namespace BwsShop\WebBundle\Controller;

use Bws\Interactor\ChangeBasket;
use Bws\Interactor\ChangeBasketRequest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Bws\Interactor\AddToBasket;
use Bws\Interactor\AddToBasketRequest;
use Bws\Interactor\ViewBasket;
use Bws\Interactor\ViewBasketRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class BasketController extends FOSRestController
{
    public function addAction()
    {
        $session = new Session();

        /** @var AddToBasket $interactor */
        $interactor = $this->get('interactor.add_to_basket');
        $response   = $interactor->execute(
            new AddToBasketRequest(
                $this->getRequest()->get('articleId', null),
                $this->getRequest()->get('count', null),
                $session->get('basketId', 0)
            )
        );

        $session->set('basketId', $response->getBasketId());
        $session->set('total', $response->getTotal());
        $session->set('posCount', $response->getPosCount());

        return $this->redirect($this->generateUrl('bws_shop_web_homepage'));
    }

    /**
     * @View()
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $session = new Session();

        /** @var ViewBasket $interactor */
        $interactor = $this->get('interactor.view_basket');
        $response   = $interactor->execute(new ViewBasketRequest($session->get('basketId', 0)));

        $view = $this->view($response, 200)
            ->setTemplate('BwsShopWebBundle:Basket:list.html.twig')
            ->setTemplateVar('response');

        $session->set('total', $response->getTotal());
        $session->set('posCount', $response->getPositionCount());

        return $this->handleView($view);
    }

    /**
     * @View()
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changeAction()
    {
        $session = new Session();

        /** @var ChangeBasket $interactor */
        $interactor = $this->get('interactor.change_basket');
        $response   = $interactor->execute(
            new ChangeBasketRequest(
                $this->getRequest()->get('articleId'),
                $session->get('basketId', 0),
                $this->getRequest()->get('count')
            )
        );

        $view = $this->view($response, 200)
            ->setTemplate('BwsShopWebBundle:Basket:change.html.twig')
            ->setTemplateVar('response');

        return $this->handleView($view);
    }
}
