<?php

namespace Bws\Repository;

use Bws\Entity\DeliveryAddress;
use Bws\Entity\DeliveryAddressStub;

class DeliveryAddressRepositoryMock implements DeliveryAddressRepository
{
    private $addresses = array();
    private $lastInserted;

    public function __construct()
    {
        $this->save(new DeliveryAddressStub());
    }

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

    public function findExisting($firstName, $lastName, $street, $zip, $city)
    {
        /** @var DeliveryAddress $address */
        foreach ($this->addresses as $address) {
            if ($address->getFirstName() == $firstName
                && $address->getLastName() == $lastName
                && $address->getStreet() == $street
                && $address->getZip() == $zip
                && $address->getCity() == $city
            ) {
                return $address;
            }
        }

        return null;
    }

    public function truncate()
    {
        $this->addresses = array();
    }
}
 