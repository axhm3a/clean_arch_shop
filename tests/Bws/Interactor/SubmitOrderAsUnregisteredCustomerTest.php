<?php

namespace Bws\Interactor;

use Bws\Entity\BasketStub;
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

        $this->assertValidOrder($request, $response);
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

        $this->assertValidOrder($request, $response);
    }

    /**
     * @param $request
     * @param $response
     */
    protected function assertValidOrder($request, $response)
    {
        $invoiceAddress = $this->invoiceAddressRepository->findLastInserted();
        $this->assertSame('Christian', $invoiceAddress->getFirstName());
        $this->assertSame('Bergau', $invoiceAddress->getLastName());
        $this->assertSame('Musterstreet 12', $invoiceAddress->getStreet());
        $this->assertSame('30163', $invoiceAddress->getZip());
        $this->assertSame('Hannover', $invoiceAddress->getCity());

        $deliveryAddress = $this->deliveryAddressRepository->findLastInserted();
        $this->assertSame('Max', $deliveryAddress->getFirstName());
        $this->assertSame('Muster', $deliveryAddress->getLastName());
        $this->assertSame('Musterstreet 22', $deliveryAddress->getStreet());
        $this->assertSame('30179', $deliveryAddress->getZip());
        $this->assertSame('Isernhagen', $deliveryAddress->getCity());

        $emailAddress = $this->emailAddressRepository->findLastInserted();
        $this->assertSame('cbergau86@gmail.com', $request->emailAddress);

        $customer = $this->customerRepository->findLastInserted();
        $this->assertSame($invoiceAddress, $customer->getLastUsedInvoiceAddress());
        $this->assertSame($deliveryAddress, $customer->getLastUsedDeliveryAddress());
        $this->assertSame($emailAddress, $customer->getLastUsedEmailAddress());
        $this->assertSame($customer, $invoiceAddress->getCustomer());
        $this->assertSame($customer, $deliveryAddress->getCustomer());
        $this->assertSame($customer, $emailAddress->getCustomer());
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
