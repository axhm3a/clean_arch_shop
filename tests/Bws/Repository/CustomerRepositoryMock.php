<?php

namespace Bws\Repository;

use Bws\Entity\Customer;
use Bws\Entity\CustomerStub;

class CustomerRepositoryMock implements CustomerRepository
{
    private $customers = array();

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
    }
}
 