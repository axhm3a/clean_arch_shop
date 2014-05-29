<?php
/**
 * BWS WebShop
 *
 * @author Christian Bergau <cbergau86@gmail.com>
 */

namespace Bws\Repository;

use Bws\Entity\Article;

interface ArticleRepository
{
    /**
     * @param $id
     *
     * @return Article
     */
    public function find($id);
}
 