<?php

namespace Bws\Entity;

class CustomerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Customer
     */
    private $customer;

    public function setUp()
    {
        $this->customer = new Customer();
    }

    public function testCustomerIsInitiallyUnregistered()
    {
        $this->assertFalse($this->customer->isRegistered());
    }

    public function testRegisterCustomer()
    {
        $this->customer->register();
        $this->assertTrue($this->customer->isRegistered());
    }
}
