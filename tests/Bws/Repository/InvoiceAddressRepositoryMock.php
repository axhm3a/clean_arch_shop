<?php

namespace Bws\Repository;

use Bws\Entity\InvoiceAddress;
use Bws\Entity\InvoiceAddressStub;

class InvoiceAddressRepositoryMock implements InvoiceAddressRepository
{
    private $addresses = array();
    private $lastInserted;

    public function __construct()
    {
        $this->save(new InvoiceAddressStub());
    }

    /**
     * @param int $id
     *
     * @return InvoiceAddress
     */
    public function find($id)
    {
        return isset($this->addresses[$id]) ? $this->addresses[$id] : null;
    }

    /**
     * @param InvoiceAddress $address
     */
    public function save(InvoiceAddress $address)
    {
        $this->addresses[$address->getId()] = $address;
        $this->lastInserted                 = $address;
    }

    /**
     * @return InvoiceAddress
     */
    public function factory()
    {
        return new InvoiceAddress();
    }

    /**
     * @return InvoiceAddress
     */
    public function findLastInserted()
    {
        return $this->lastInserted;
    }

    public function findExisting($firstName, $lastName, $street, $zip, $city)
    {
        /** @var InvoiceAddress $address */
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
}
 