<?php

namespace Bws\DoctrineBundle\Entity;

use Bws\Entity\Customer as BaseCustomer;
use Bws\Repository\CustomerRepository as BaseCustomerRepository;
use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository implements BaseCustomerRepository
{
    /**
     * @return BaseCustomer
     */
    public function factory()
    {
        return new Customer();
    }

    public function save(BaseCustomer $customer)
    {
        $this->getEntityManager()->persist($customer);
        $this->getEntityManager()->flush();
    }
}
