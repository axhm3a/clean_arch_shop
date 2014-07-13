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

    public function findExisting($firstName, $lastName, $street, $zip, $city)
    {
        $result = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('i')
            ->from('Bws\DoctrineBundle\Entity\InvoiceAddress', 'i')
            ->where('i.firstName = :firstName')
            ->andWhere('i.lastName = :lastName')
            ->andWhere('i.lastName = :street')
            ->andWhere('i.lastName = :zip')
            ->andWhere('i.lastName = :city')
            ->orderBy('i.id', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        $invoiceAddress = isset($result[0]) ? $result[0] : null;

        return $invoiceAddress;
    }
}
