<?php

namespace Bws\Interactor;

class PresentArticlesResponse
{
    private $articles;

    public function __construct($articles)
    {
        $this->articles = $articles;
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }
}
 