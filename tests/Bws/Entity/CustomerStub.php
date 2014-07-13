<?php

namespace Bws\Entity;

class CustomerStub extends Customer
{
    const ID = 12345;

    public function __construct()
    {
        $this->id = self::ID;
    }
}
 