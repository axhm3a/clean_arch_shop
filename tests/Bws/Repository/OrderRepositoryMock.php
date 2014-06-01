<?php

namespace Bws\Repository;

use Bws\Entity\Order;

class OrderRepositoryMock implements OrderRepository
{
    private $orders = array();
    private $lastInserted;

    /**
     * @param Order $order
     */
    public function save(Order $order)
    {
        if (null === $order->getId()) {
            $order->setId(time());
        }

        $this->orders[$order->getId()] = $order;
        $this->lastInserted            = $order;
    }

    /**
     * @return Order
     */
    public function factory()
    {
        return new Order();
    }

    /**
     * @return Order
     */
    public function findLastInserted()
    {
        return $this->lastInserted;
    }
}
 