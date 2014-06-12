<?php

namespace Bws\Repository;

use Bws\Entity\PaymentMethod;

class PaymentMethodRepositoryMock implements PaymentMethodRepository
{
    /**
     * @return PaymentMethod[]
     */
    public function findAll()
    {
        $invoice = new PaymentMethod();
        $invoice->setName('Invoice');

        $cashOnDelivery = new PaymentMethod();
        $cashOnDelivery->setName('Cash on Delivery');

        return array($invoice, $cashOnDelivery);
    }
}
 