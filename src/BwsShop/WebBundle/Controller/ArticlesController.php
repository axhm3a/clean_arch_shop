<?php

namespace BwsShop\WebBundle\Controller;

use Bws\Interactor\SearchArticlesRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticlesController extends Controller
{
    public function indexAction()
    {
        $articles = $this->get('interactor.present_articles')->execute()->getArticles();
        return $this->render('BwsShopWebBundle:ListArticles:index.html.twig', array('articles' => $articles));
    }

    public function searchAction(Request $request)
    {
        $searchRequest = new SearchArticlesRequest($request->get('by'));
        $articles      = $this->get('interactor.search_articles')->execute($searchRequest)->getArticles();
        return $this->render('BwsShopWebBundle:ListArticles:index.html.twig', array('articles' => $articles));
    }
}
