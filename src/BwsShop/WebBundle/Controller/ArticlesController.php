<?php

namespace BwsShop\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticlesController extends Controller
{
    public function indexAction()
    {
        $articles = $this->get('article.repository')->findAll();
        return $this->render('BwsShopWebBundle:ListArticles:index.html.twig', array('articles' => $articles));
    }
}
