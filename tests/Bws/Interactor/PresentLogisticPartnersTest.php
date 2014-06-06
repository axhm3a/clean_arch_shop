<?php

namespace Bws\Interactor;

use Bws\Repository\LogisticPartnerRepositoryMock;

class PresentLogisticPartnersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PresentLogisticPartners
     */
    private $interactor;

    /**
     * @var LogisticPartnerRepositoryMock
     */
    private $logisticPartnerRepository;

    public function setUp()
    {
        $this->logisticPartnerRepository = new LogisticPartnerRepositoryMock();
        $this->interactor                = new PresentLogisticPartners($this->logisticPartnerRepository);
    }

    public function testReturnsLogisticPartners()
    {
        $logisticPartners = $this->logisticPartnerRepository->findAll();
        $response         = $this->interactor->execute();

        $this->assertEquals(
            array(
                array(
                    'id'   => $logisticPartners[0]->getId(),
                    'name' => $logisticPartners[0]->getName(),
                ),
                array(
                    'id'   => $logisticPartners[1]->getId(),
                    'name' => $logisticPartners[1]->getName(),
                )
            ),
            $response->getLogisticPartners()
        );
    }
}
 