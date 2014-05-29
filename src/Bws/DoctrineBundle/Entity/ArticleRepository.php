<?php

namespace Bws\DoctrineBundle\Entity;

use Bws\Repository\ArticleRepository as BaseArticleRepository;
use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository implements BaseArticleRepository
{

}
