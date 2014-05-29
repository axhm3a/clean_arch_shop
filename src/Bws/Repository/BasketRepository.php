<?php

namespace Bws\Repository;

use Bws\Entity\Basket;
use Bws\Entity\BasketPosition;

interface BasketRepository
{
    /**
     * @param int $id
     *
     * @return Basket
     */
    public function find($id);

    /**
     * @param Basket $basket
     */
    public function save(Basket $basket);

    /**
     * @return Basket
     */
    public function factory();
}
