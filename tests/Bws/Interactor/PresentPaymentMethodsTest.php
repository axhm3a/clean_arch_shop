<?php

namespace Bws\Interactor;

use Bws\Repository\PaymentMethodRepositoryMock;

class PresentPaymentMethodsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PresentPaymentMethods
     */
    private $interactor;

    /**
     * @var PaymentMethodRepositoryMock
     */
    private $paymentRepository;

    public function setUp()
    {
        $this->paymentRepository = new PaymentMethodRepositoryMock();
        $this->interactor        = new PresentPaymentMethods($this->paymentRepository);
    }

    public function testReturnsPaymentMethods()
    {
        $paymentMethods = $this->paymentRepository->findAll();
        $response       = $this->interactor->execute();

        $this->assertEquals(
            array(
                array(
                    'id'   => $paymentMethods[0]->getId(),
                    'name' => $paymentMethods[0]->getName()
                ),
                array(
                    'id'   => $paymentMethods[1]->getId(),
                    'name' => $paymentMethods[1]->getName()
                )
            ),
            $response->getPaymentMethods()
        );
    }
}
