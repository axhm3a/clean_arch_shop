<?php

namespace BwsShop\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticlesController extends Controller
{
    public function indexAction()
    {
        $articles = $this->get('interactor.present_articles')->execute()->getArticles();
        return $this->render('BwsShopWebBundle:ListArticles:index.html.twig', array('articles' => $articles));
    }
}
