<?php
/**
 * BWS WebShop
 *
 * @author Christian Bergau <cbergau86@gmail.com>
 */

namespace Bws\Repository;

use Bws\Entity\Customer;

interface CustomerRepository
{
    /**
     * @return Customer
     */
    public function factory();

    public function save(Customer $customer);
}
 