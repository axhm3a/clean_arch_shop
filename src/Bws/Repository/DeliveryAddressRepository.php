<?php
/**
 * BWS WebShop
 *
 * @author Christian Bergau <cbergau86@gmail.com>
 */

namespace Bws\Repository;

use Bws\Entity\DeliveryAddress;

interface DeliveryAddressRepository
{
    /**
     * @param DeliveryAddress $deliveryAddress
     */
    public function save(DeliveryAddress $deliveryAddress);

    /**
     * @return DeliveryAddress
     */
    public function factory();
}
 