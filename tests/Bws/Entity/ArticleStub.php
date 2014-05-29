<?php

namespace Bws\Entity;

class ArticleStub extends Article
{
    const ID = 12;

    const TITLE = 'some title';

    const PRICE = 9.99;

    const IMAGE_PATH = '/path/to/image.png';

    public function getEan()
    {
        return '978-013235088';
    }

    public function getTitle()
    {
        return self::TITLE;
    }

    public function getDescription()
    {
        return 'some description';
    }

    public function getPrice()
    {
        return self::PRICE;
    }

    public function getImagePath()
    {
        return self::IMAGE_PATH;
    }

    public function getId()
    {
        return self::ID;
    }

}
 