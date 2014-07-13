<?php

namespace Bws\Repository;

use Bws\Entity\PaymentMethod;

class PaymentMethodRepositoryMock implements PaymentMethodRepository
{
    const INVOICE_ID = 3;
    const COD_ID = 4;

    private $paymentMethods = array();

    public function __construct()
    {
        $invoice = new PaymentMethod();
        $invoice->setId(static::INVOICE_ID);
        $invoice->setName('Invoice');

        $cashOnDelivery = new PaymentMethod();
        $cashOnDelivery->setId(static::COD_ID);
        $cashOnDelivery->setName('Cash on Delivery');

        $this->paymentMethods[] = $invoice;
        $this->paymentMethods[] = $cashOnDelivery;
    }

    /**
     * @return PaymentMethod[]
     */
    public function findAll()
    {
        return $this->paymentMethods;
    }

    /**
     * @param int $id
     *
     * @return PaymentMethod
     */
    public function find($id)
    {
        /** @var PaymentMethod $paymentMethod */
        foreach ($this->paymentMethods as $paymentMethod) {
            if ($paymentMethod->getId() == $id) {
                return $paymentMethod;
            }
        }

        return null;
    }
}
 