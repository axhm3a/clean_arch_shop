<?php

namespace Bws\Interactor;

use Bws\Entity\BasketStub;
use Bws\Repository\BasketRepositoryMock;
use Bws\Repository\CustomerRepositoryMock;
use Bws\Repository\DeliveryAddressRepositoryMock;
use Bws\Repository\InvoiceAddressRepositoryMock;
use Bws\Repository\OrderRepositoryMock;

class SubmitOrderAsUnregisteredCustomerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SubmitOrderAsUnregisteredCustomer
     */
    private $interactor;

    /**
     * @var InvoiceAddressRepositoryMock
     */
    private $invoiceAddressRepository;

    /**
     * @var DeliveryAddressRepositoryMock
     */
    private $deliveryAddressRepository;

    /**
     * @var BasketRepositoryMock
     */
    private $basketRepository;

    /**
     * @var OrderRepositoryMock
     */
    private $orderRepository;

    /**
     * @var CustomerRepositoryMock
     */
    private $customerRepository;

    public function setUp()
    {
        $this->invoiceAddressRepository  = new InvoiceAddressRepositoryMock();
        $this->deliveryAddressRepository = new DeliveryAddressRepositoryMock();
        $this->basketRepository          = new BasketRepositoryMock();
        $this->orderRepository           = new OrderRepositoryMock();
        $this->customerRepository        = new CustomerRepositoryMock();

        $this->interactor = new SubmitOrderAsUnregisteredCustomer(
            $this->invoiceAddressRepository,
            $this->deliveryAddressRepository,
            $this->basketRepository,
            $this->orderRepository,
            $this->customerRepository
        );
    }

    public function testSavesData()
    {
        $request                   = new SubmitOrderAsUnregisteredCustomerRequest();
        $request->invoiceFirstName = 'Christian';
        $request->invoiceLastName  = 'Bergau';
        $request->invoiceStreet    = 'Musterstreet 12';
        $request->invoiceZip       = '30163';
        $request->invoiceCity      = 'Hannover';

        $request->emailAddress     = 'cbergau86@gmail.com';

        $request->deliveryFirstName = 'Max';
        $request->deliveryLastName  = 'Muster';
        $request->deliveryStreet    = 'Musterstreet 22';
        $request->deliveryZip       = '30179';
        $request->deliveryCity      = 'Isernhagen';

        $request->basketId = BasketStub::ID;

        $response = $this->interactor->execute($request);

        $invoiceAddress = $this->invoiceAddressRepository->findLastInserted();
        $this->assertEquals('Christian', $invoiceAddress->getFirstName());
        $this->assertEquals('Bergau', $invoiceAddress->getLastName());
        $this->assertEquals('Musterstreet 12', $invoiceAddress->getStreet());
        $this->assertEquals('30163', $invoiceAddress->getZip());
        $this->assertEquals('Hannover', $invoiceAddress->getCity());

        $deliveryAddress = $this->deliveryAddressRepository->findLastInserted();
        $this->assertEquals('Max', $deliveryAddress->getFirstName());
        $this->assertEquals('Muster', $deliveryAddress->getLastName());
        $this->assertEquals('Musterstreet 22', $deliveryAddress->getStreet());
        $this->assertEquals('30179', $deliveryAddress->getZip());
        $this->assertEquals('Isernhagen', $deliveryAddress->getCity());

        $savedOrder = $this->orderRepository->findLastInserted();
        $this->assertSame($invoiceAddress, $savedOrder->getInvoiceAddress());
        $this->assertSame($deliveryAddress, $savedOrder->getDeliveryAddress());

        $this->assertNotNull($response->getOrderId());
        $this->assertEquals(BasketStub::ID, $savedOrder->getBasket()->getId());
        $this->assertEquals(SubmitOrderResponse::SUCCESS, $response->getCode());
        $this->assertEquals('', $response->getMessage());
    }
}
