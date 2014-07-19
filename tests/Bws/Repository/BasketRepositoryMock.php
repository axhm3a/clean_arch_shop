<?php

namespace Bws\Repository;

use Bws\Entity\Basket;
use Bws\Entity\BasketStub;
use Bws\Entity\EmptyBasketStub;

class BasketRepositoryMock implements BasketRepository
{
    private $baskets = array();
    private $findById;

    public function __construct()
    {
        $this->save(new BasketStub());
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
        if ($basket->getId() == null) {
            $basket->setId(time());
        }
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

    public function truncate()
    {
        $this->baskets = array();
    }
}
 