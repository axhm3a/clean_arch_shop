<?php
/**
 * BWS WebShop
 *
 * @author Christian Bergau <cbergau86@gmail.com>
 */

namespace Bws\Repository;

use Bws\Entity\Order;

interface OrderRepository
{
    /**
     * @param Order $order
     */
    public function save(Order $order);

    /**
     * @return Order
     */
    public function factory();
}
