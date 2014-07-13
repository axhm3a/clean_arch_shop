<?php

namespace Bws\Repository;

use Bws\Entity\LogisticPartner;

class LogisticPartnerRepositoryMock implements LogisticPartnerRepository
{
    const DHL_ID = 1;
    const HERMES_ID = 2;

    private $logisticPartners = array();

    public function __construct()
    {
        $dhl = new LogisticPartner();
        $dhl->setId(static::DHL_ID);
        $dhl->setName('DHL');

        $hermes = new LogisticPartner();
        $hermes->setId(static::HERMES_ID);
        $hermes->setName('Hermes');

        $this->logisticPartners[] = $dhl;
        $this->logisticPartners[] = $hermes;
    }

    /**
     * @return LogisticPartner[]
     */
    public function findAll()
    {
        return $this->logisticPartners;
    }

    /**
     * @param int $id
     *
     * @return LogisticPartner
     */
    public function find($id)
    {
        /** @var LogisticPartner $logisticPartner */
        foreach ($this->logisticPartners as $logisticPartner) {
            if ($logisticPartner->getId() == $id) {
                return $logisticPartner;
            }
        }

        return null;
    }
}
 