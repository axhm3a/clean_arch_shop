<?php

namespace Bws\DoctrineBundle\Entity;

use Bws\Entity\InvoiceAddress as BaseInvoiceAddress;
use Bws\Repository\InvoiceAddressRepository as BaseInvoiceAddressRepository;
use Doctrine\ORM\EntityRepository;

class InvoiceAddressRepository extends EntityRepository implements BaseInvoiceAddressRepository
{
    /**
     * @param BaseInvoiceAddress $invoiceAddress
     */
    public function save(BaseInvoiceAddress $invoiceAddress)
    {
        $this->getEntityManager()->persist($invoiceAddress);
        $this->getEntityManager()->flush();
    }

    /**
     * @return BaseInvoiceAddress
     */
    public function factory()
    {
        return new InvoiceAddress();
    }
}
