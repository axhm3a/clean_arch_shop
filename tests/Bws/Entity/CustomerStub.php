<?php

namespace Bws\Entity;

class CustomerStub extends Customer
{
    const ID              = 12345;
    const CUSTOMER_STRING = 'CHRISTIAN-BERGAU-GRADESTRAßE15-30163-HANNOVER';

    public function __construct()
    {
        $this->id             = static::ID;
        $this->customerString = static::CUSTOMER_STRING;
    }
}
