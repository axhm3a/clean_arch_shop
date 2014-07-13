<?php

namespace Bws\Entity;

class InvoiceAddressStub extends InvoiceAddress
{
    const FIRST_NAME = 'Christian';
    const LAST_NAME  = 'Bergau';
    const STREET     = 'Gradestraße 15';
    const ZIP        = '30163';
    const CITY       = 'Hannover';

    public function __construct()
    {
        $this->setFirstName(static::FIRST_NAME);
        $this->setLastName(static::LAST_NAME);
        $this->setStreet(static::STREET);
        $this->setZip(static::ZIP);
        $this->setCity(static::CITY);
    }
}
 