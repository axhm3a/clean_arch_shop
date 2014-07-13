<?php

namespace Bws\Interactor;

use Bws\Entity\BasketStub;
use Bws\Entity\CustomerStub;
use Bws\Entity\DeliveryAddressStub;
use Bws\Entity\EmailAddressStub;
use Bws\Entity\InvoiceAddressStub;
use Bws\Repository\BasketRepositoryMock;
use Bws\Repository\CustomerRepositoryMock;
use Bws\Repository\DeliveryAddressRepositoryMock;
use Bws\Repository\EmailAddressRepositoryMock;
use Bws\Repository\InvoiceAddressRepositoryMock;
use Bws\Repository\LogisticPartnerRepositoryMock;
use Bws\Repository\OrderRepositoryMock;
use Bws\Repository\PaymentMethodRepositoryMock;

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

    /**
     * @var EmailAddressRepositoryMock
     */
    private $emailAddressRepository;

    /**
     * @var PaymentMethodRepositoryMock
     */
    private $paymentMethodRepository;

    /**
     * @var LogisticPartnerRepositoryMock
     */
    private $logisticPartnerRepository;

    public function setUp()
    {
        $this->invoiceAddressRepository  = new InvoiceAddressRepositoryMock();
        $this->deliveryAddressRepository = new DeliveryAddressRepositoryMock();
        $this->basketRepository          = new BasketRepositoryMock();
        $this->orderRepository           = new OrderRepositoryMock();
        $this->customerRepository        = new CustomerRepositoryMock();
        $this->emailAddressRepository    = new EmailAddressRepositoryMock();
        $this->paymentMethodRepository   = new PaymentMethodRepositoryMock();
        $this->logisticPartnerRepository = new LogisticPartnerRepositoryMock();

        $this->interactor = new SubmitOrderAsUnregisteredCustomer(
            $this->invoiceAddressRepository,
            $this->deliveryAddressRepository,
            $this->basketRepository,
            $this->orderRepository,
            $this->customerRepository,
            $this->emailAddressRepository,
            $this->paymentMethodRepository,
            $this->logisticPartnerRepository
        );
    }

    public function testSavesDataAsNonRegisteringCustomer()
    {
        $request                    = new SubmitOrderAsUnregisteredCustomerRequest();
        $request->invoiceFirstName  = 'Christian';
        $request->invoiceLastName   = 'Bergau';
        $request->invoiceStreet     = 'Musterstreet 12';
        $request->invoiceZip        = '30163';
        $request->invoiceCity       = 'Hannover';
        $request->emailAddress      = 'cbergau86@gmail.com';
        $request->deliveryFirstName = 'Max';
        $request->deliveryLastName  = 'Muster';
        $request->deliveryStreet    = 'Musterstreet 22';
        $request->deliveryZip       = '30179';
        $request->deliveryCity      = 'Isernhagen';
        $request->basketId          = BasketStub::ID;
        $request->paymentMethodId   = PaymentMethodRepositoryMock::INVOICE_ID;
        $request->logisticPartnerId = LogisticPartnerRepositoryMock::HERMES_ID;
        $request->registering       = false;

        $response = $this->interactor->execute($request);

        $this->assertValidOrderForNewCustomer($request, $response);
    }

    public function testSavesDataAsRegisteringCustomer()
    {
        $request                    = new SubmitOrderAsUnregisteredCustomerRequest();
        $request->invoiceFirstName  = 'Christian';
        $request->invoiceLastName   = 'Bergau';
        $request->invoiceStreet     = 'Musterstreet 12';
        $request->invoiceZip        = '30163';
        $request->invoiceCity       = 'Hannover';
        $request->emailAddress      = 'cbergau86@gmail.com';
        $request->deliveryFirstName = 'Max';
        $request->deliveryLastName  = 'Muster';
        $request->deliveryStreet    = 'Musterstreet 22';
        $request->deliveryZip       = '30179';
        $request->deliveryCity      = 'Isernhagen';
        $request->basketId          = BasketStub::ID;
        $request->paymentMethodId   = PaymentMethodRepositoryMock::INVOICE_ID;
        $request->logisticPartnerId = LogisticPartnerRepositoryMock::HERMES_ID;
        $request->registering       = true;

        $response = $this->interactor->execute($request);

        $this->assertValidOrderForNewCustomer($request, $response);
    }

    public function testSavesDataAsRegisteringReturningCustomer()
    {
        $request                    = new SubmitOrderAsUnregisteredCustomerRequest();
        $request->invoiceFirstName  = InvoiceAddressStub::FIRST_NAME;
        $request->invoiceLastName   = InvoiceAddressStub::LAST_NAME;
        $request->invoiceStreet     = InvoiceAddressStub::STREET;
        $request->invoiceZip        = InvoiceAddressStub::ZIP;
        $request->invoiceCity       = InvoiceAddressStub::CITY;
        $request->emailAddress      = EmailAddressStub::ADDRESS;
        $request->deliveryFirstName = DeliveryAddressStub::FIRST_NAME;
        $request->deliveryLastName  = DeliveryAddressStub::LAST_NAME;
        $request->deliveryStreet    = DeliveryAddressStub::STREET;
        $request->deliveryZip       = DeliveryAddressStub::ZIP;
        $request->deliveryCity      = DeliveryAddressStub::CITY;
        $request->basketId          = BasketStub::ID;
        $request->paymentMethodId   = PaymentMethodRepositoryMock::INVOICE_ID;
        $request->logisticPartnerId = LogisticPartnerRepositoryMock::HERMES_ID;
        $request->registering       = true;

        $response = $this->interactor->execute($request);

        $this->assertValidOrderForNewCustomer($request, $response, true);
    }

    /**
     * @param SubmitOrderAsUnregisteredCustomerRequest $request
     * @param SubmitOrderResponse                      $response
     * @param bool                                     $shouldBeMatchedCustomer
     */
    protected function assertValidOrderForNewCustomer(
        SubmitOrderAsUnregisteredCustomerRequest $request,
        SubmitOrderResponse $response,
        $shouldBeMatchedCustomer = false
    ) {
        $invoiceAddress = $this->invoiceAddressRepository->findLastInserted();

        if ($shouldBeMatchedCustomer) {
            $this->assertEquals(InvoiceAddressStub::ID, $invoiceAddress->getId());
        } else {
            $this->assertNotEquals(InvoiceAddressStub::ID, $invoiceAddress->getId());
        }

        $this->assertSame($request->invoiceFirstName, $invoiceAddress->getFirstName());
        $this->assertSame($request->invoiceLastName, $invoiceAddress->getLastName());
        $this->assertSame($request->invoiceStreet, $invoiceAddress->getStreet());
        $this->assertSame($request->invoiceZip, $invoiceAddress->getZip());
        $this->assertSame($request->invoiceCity, $invoiceAddress->getCity());

        $deliveryAddress = $this->deliveryAddressRepository->findLastInserted();

        if ($shouldBeMatchedCustomer) {
            $this->assertEquals(DeliveryAddressStub::ID, $deliveryAddress->getId());
        } else {
            $this->assertNotEquals(DeliveryAddressStub::ID, $deliveryAddress->getId());
        }

        $this->assertSame($request->deliveryFirstName, $deliveryAddress->getFirstName());
        $this->assertSame($request->deliveryLastName, $deliveryAddress->getLastName());
        $this->assertSame($request->deliveryStreet, $deliveryAddress->getStreet());
        $this->assertSame($request->deliveryZip, $deliveryAddress->getZip());
        $this->assertSame($request->deliveryCity, $deliveryAddress->getCity());

        $emailAddress = $this->emailAddressRepository->findLastInserted();

        if ($shouldBeMatchedCustomer) {
            $this->assertEquals(EmailAddressStub::ID, $emailAddress->getId());
        } else {
            $this->assertNotEquals(EmailAddressStub::ID, $emailAddress->getId());
        }

        $this->assertSame($request->emailAddress, $emailAddress->getAddress());

        $customer = $this->customerRepository->findLastInserted();

        if ($shouldBeMatchedCustomer) {
            $this->assertEquals(CustomerStub::ID, $customer->getId());
        }

        $this->assertSame($invoiceAddress, $customer->getLastUsedInvoiceAddress());
        $this->assertSame($deliveryAddress, $customer->getLastUsedDeliveryAddress());
        $this->assertSame($emailAddress, $customer->getLastUsedEmailAddress());
        $this->assertSame($customer, $invoiceAddress->getCustomer());
        $this->assertSame($customer, $deliveryAddress->getCustomer());
        $this->assertSame($customer->getId(), $emailAddress->getCustomer()->getId());
        $this->assertSame($request->registering, $customer->isRegistered());

        $order = $this->orderRepository->findLastInserted();
        $this->assertSame($invoiceAddress, $order->getInvoiceAddress());
        $this->assertSame($deliveryAddress, $order->getDeliveryAddress());
        $this->assertSame('Invoice', $order->getPaymentMethod()->getName());
        $this->assertSame('Hermes', $order->getLogisticPartner()->getName());
        $this->assertSame($customer, $order->getCustomer());
        $this->assertSame($emailAddress, $order->getEmailAddress());

        $this->assertNotNull($response->getOrderId());
        $this->assertSame(BasketStub::ID, $order->getBasket()->getId());
        $this->assertSame(SubmitOrderResponse::SUCCESS, $response->getCode());
        $this->assertSame('', $response->getMessage());
    }
}
