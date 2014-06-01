<?php

namespace Bws\Repository;

use Bws\Entity\DeliveryAddress;

class DeliveryAddressRepositoryMock implements DeliveryAddressRepository
{
    private $addresses = array();
    private $lastInserted;

    /**
     * @param int $id
     *
     * @return DeliveryAddress
     */
    public function find($id)
    {
        return isset($this->addresses[$id]) ? $this->addresses[$id] : null;
    }

    /**
     * @param DeliveryAddress $address
     */
    public function save(DeliveryAddress $address)
    {
        $this->addresses[$address->getId()] = $address;
        $this->lastInserted                 = $address;
    }

    /**
     * @return DeliveryAddress
     */
    public function factory()
    {
        return new DeliveryAddress();
    }

    /**
     * @return DeliveryAddress
     */
    public function findLastInserted()
    {
        return $this->lastInserted;
    }
}
 