<?php

namespace Bws\Repository;

use Bws\Entity\Basket;
use Bws\Entity\EmptyBasketStub;

class BasketRepositoryMock implements BasketRepository
{
    const BASKET_ID = 5;

    private $baskets = array();
    private $findById;

    public function __construct()
    {
        $basket = new Basket();
        $basket->setId(self::BASKET_ID);
        $this->baskets[$basket->getId()] = $basket;
        $this->save(new EmptyBasketStub());
    }

    /**
     * @param int $id
     *
     * @return Basket
     */
    public function find($id)
    {
        $this->findById = $id;
        return isset($this->baskets[$id]) ? $this->baskets[$id] : null;
    }

    /**
     * @param Basket $basket
     */
    public function save(Basket $basket)
    {
        $this->baskets[$basket->getId()] = $basket;
    }

    /**
     * @return Basket
     */
    public function factory()
    {
        return new Basket();
    }

    /**
     * @return mixed
     */
    public function getFindByIdArgument()
    {
        return $this->findById;
    }
}
 