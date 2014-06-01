<?php

namespace Bws\DoctrineBundle\Entity;

use Bws\Entity\DeliveryAddress as BaseDeliveryAddress;
use Bws\Repository\DeliveryAddressRepository as BaseDeliveryAddressRepository;
use Doctrine\ORM\EntityRepository;

class DeliveryAddressRepository extends EntityRepository implements BaseDeliveryAddressRepository
{
    /**
     * @param BaseDeliveryAddress $deliveryAddress
     */
    public function save(BaseDeliveryAddress $deliveryAddress)
    {
        $this->getEntityManager()->persist($deliveryAddress);
        $this->getEntityManager()->flush();
    }

    /**
     * @return DeliveryAddress
     */
    public function factory()
    {
        return new DeliveryAddress();
    }
}
