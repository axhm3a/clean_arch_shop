<?php

namespace Bws\Repository;

use Bws\Entity\InvoiceAddress;

class InvoiceAddressRepositoryMock implements InvoiceAddressRepository
{
    private $addresses = array();
    private $lastInserted;

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
}
 