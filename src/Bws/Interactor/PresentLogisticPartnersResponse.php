<?php

namespace Bws\Interactor;

class PresentLogisticPartnersResponse
{
    private $logisticPartners = array();

    public function __construct(array $logisticPartners)
    {
        $this->logisticPartners = $logisticPartners;
    }

    /**
     * @return array
     */
    public function getLogisticPartners()
    {
        return $this->logisticPartners;
    }
}
 