<?php

namespace Bws\Repository;

use Bws\Entity\Article;
use Bws\Entity\ArticleStub;

class ArticleRepositoryMock implements ArticleRepository
{
    const ARTICLE_ID = 10;

    private $articles = array();
    private $findById;

    public function __construct()
    {
        $this->save(new ArticleStub());
    }

    /**
     * @param int $id
     *
     * @return Article
     */
    public function find($id)
    {
        $this->findById = $id;
        return isset($this->articles[$id]) ? $this->articles[$id] : null;
    }

    /**
     * @param Article $article
     */
    public function save(Article $article)
    {
        $this->articles[$article->getId()] = $article;
    }

    /**
     * @return Article
     */
    public function factory()
    {
        return new Article();
    }

    /**
     * @return mixed
     */
    public function getFindByIdArgument()
    {
        return $this->findById;
    }

    public function findAll()
    {
        return $this->articles;
    }

    public function deleteAll()
    {
        $this->articles = array();
    }
}
 