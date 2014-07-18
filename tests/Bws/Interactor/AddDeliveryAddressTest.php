<?php

namespace Bws\Interactor;

use Bws\Entity\CustomerStub;
use Bws\Repository\CustomerRepositoryMock;
use Bws\Repository\DeliveryAddressRepositoryMock;

class AddDeliveryAddressTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CustomerRepositoryMock
     */
    private $customerRepository;

    /**
     * @var DeliveryAddressRepositoryMock
     */
    private $deliveryAddressRepository;

    /**
     * @var AddDeliveryAddress
     */
    private $interactor;

    public function setUp()
    {
        $this->customerRepository        = new CustomerRepositoryMock();
        $this->deliveryAddressRepository = new DeliveryAddressRepositoryMock();
        $this->interactor                = new AddDeliveryAddress($this->customerRepository, $this->deliveryAddressRepository);
    }

    public function testCustomerNotFoundShouldReturnError()
    {
        $request             = new AddDeliveryAddressRequest();
        $request->customerId = 0;

        $result = $this->interactor->execute($request);

        $this->assertEquals($result::CUSTOMER_NOT_FOUND, $result->code);
    }

    public function testAddressSavedShouldReturnSuccess()
    {
        $request             = new AddDeliveryAddressRequest();
        $request->customerId = CustomerStub::ID;
        $request->firstName  = 'Max';
        $request->lastName   = 'Mustermann';
        $request->street     = 'Musterstraße 55';
        $request->city       = 'Hannover';
        $request->zip        = '12345';

        $result = $this->interactor->execute($request);

        $lastInserted = $this->deliveryAddressRepository->findLastInserted();

        $this->assertEquals($result::SUCCESS, $result->code);
        $this->assertEquals($request->firstName, $lastInserted->getFirstName());
        $this->assertEquals($request->lastName, $lastInserted->getLastName());
        $this->assertEquals($request->street, $lastInserted->getStreet());
        $this->assertEquals($request->zip, $lastInserted->getZip());
        $this->assertEquals($request->city, $lastInserted->getCity());
        $this->assertEquals(new CustomerStub(), $lastInserted->getCustomer());
    }
}
 