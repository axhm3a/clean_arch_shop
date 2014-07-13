<?php

namespace Bws\Repository;

use Bws\Entity\Customer;
use Bws\Entity\CustomerStub;

class CustomerRepositoryMock implements CustomerRepository
{
    private $customers = array();
    private $lastInserted;

    /**
     * @return Customer
     */
    public function factory()
    {
        return new CustomerStub();
    }

    public function save(Customer $customer)
    {
        $this->customers[] = $customer;
        $this->lastInserted = $customer;
    }

    /**
     * @return Customer
     */
    public function findLastInserted()
    {
        return $this->lastInserted;
    }
}
 