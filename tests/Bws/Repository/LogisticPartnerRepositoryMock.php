<?php

namespace Bws\Repository;

use Bws\Entity\LogisticPartner;

class LogisticPartnerRepositoryMock implements LogisticPartnerRepository
{
    /**
     * @return LogisticPartner[]
     */
    public function findAll()
    {
        $dhl = new LogisticPartner();
        $dhl->setName('DHL');

        $hermes = new LogisticPartner();
        $hermes->setName('Hermes');

        return array($dhl, $hermes);
    }
}
 