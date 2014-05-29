<?php

namespace Bws\Entity;

class ArticleStub extends Article
{
    const ID = 12;

    public function getEan()
    {
        return '978-013235088';
    }

    public function getTitle()
    {
        return 'some title';
    }

    public function getDescription()
    {
        return 'some description';
    }

    public function getPrice()
    {
        return 9.99;
    }

    public function getImagePath()
    {
        return '/path/to/image.png';
    }

    public function getId()
    {
        return self::ID;
    }

}
 