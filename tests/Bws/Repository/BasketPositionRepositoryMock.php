<?php

namespace Bws\Repository;

use Bws\Entity\ArticleStub;
use Bws\Entity\Basket;
use Bws\Entity\BasketPosition;
use Bws\Entity\BasketPositionStub;
use Bws\Entity\BasketStub;

class BasketPositionRepositoryMock implements BasketPositionRepository
{
    private $positions = array();
    private $findById;
    private $addToBasketCalls = 0;
    private $removeCalls = 0;

    public function __construct()
    {
        $position = new BasketPositionStub();
        $position->setBasket(new BasketStub());
        $this->positions[$position->getId()] = $position;
    }

    /**
     * @param int $id
     *
     * @return BasketPosition
     */
    public function find($id)
    {
        $this->findById = $id;
        return isset($this->positions[$id]) ? $this->positions[$id] : null;
    }

    /**
     * @return Basket
     */
    public function factory()
    {
        return new BasketPosition();
    }

    /**
     * @return mixed
     */
    public function getFindByIdArgument()
    {
        return $this->findById;
    }

    /**
     * @param Basket $basket
     *
     * @return BasketPosition[]
     */
    public function findByBasket(Basket $basket)
    {
        $positions = array();

        /** @var BasketPosition $position */
        foreach ($this->positions as $position) {
            if ($position->getBasket()->getId() == $basket->getId()) {
                $positions[] = $position;
            }
        }

        return $positions;
    }

    /**
     * @param BasketPosition $basketPosition
     */
    public function addToBasket(BasketPosition $basketPosition)
    {
        $this->addToBasketCalls++;
        $this->positions[$basketPosition->getId()] = $basketPosition;
    }

    /**
     * @param BasketPosition $position
     *
     * @return mixed
     */
    public function removeFromBasket(BasketPosition $position)
    {
        $this->removeCalls++;
        unset($this->positions[$position->getId()]);
    }

    /**
     * @return BasketPosition[]
     */
    public function findAll()
    {
        return $this->positions;
    }

    /**
     * @return int
     */
    public function getAddToBasketCalls()
    {
        return $this->addToBasketCalls;
    }

    /**
     * @return int
     */
    public function getRemoveCalls()
    {
        return $this->removeCalls;
    }
}
 