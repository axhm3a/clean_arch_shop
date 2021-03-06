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

class SubmitOrderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SubmitOrder
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

    /**
     * @var PresentLastUsedAddress
     */
    private $presentLastUsedAddress;

    /**
     * @var PresentCurrentAddress
     */
    private $presentCurrentAddress;

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
        $this->presentLastUsedAddress    = new PresentLastUsedAddress(
            $this->customerRepository
        );
        $this->presentCurrentAddress     = new PresentCurrentAddress(
            $this->deliveryAddressRepository,
            $this->invoiceAddressRepository,
            $this->presentLastUsedAddress
        );

        $this->interactor = new SubmitOrder(
            $this->invoiceAddressRepository,
            $this->deliveryAddressRepository,
            $this->basketRepository,
            $this->orderRepository,
            $this->customerRepository,
            $this->emailAddressRepository,
            $this->paymentMethodRepository,
            $this->logisticPartnerRepository,
            $this->presentCurrentAddress
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

        $response = $this->interactor->asUnregisteredCustomer($request);

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

        $response = $this->interactor->asUnregisteredCustomer($request);

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

        $response = $this->interactor->asUnregisteredCustomer($request);

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

    public function testRegisteredCustomerOrderWhenCustomerNotFoundShouldReturnError()
    {
        $this->customerRepository->truncate();
        $request                    = new SubmitOrderAsRegisteredCustomerRequest();
        $request->customerId        = 999;
        $request->selectedDelivery  = DeliveryAddressStub::ID;
        $request->basketId          = BasketStub::ID;
        $request->paymentMethodId   = PaymentMethodRepositoryMock::COD_ID;
        $request->logisticPartnerId = LogisticPartnerRepositoryMock::DHL_ID;

        $result = $this->interactor->asRegisteredCustomer($request);

        $this->assertEquals($result::CUSTOMER_NOT_FOUND, $result->getCode());
    }

    public function testRegisteredCustomerOrderWhenDeliveryAddressNotFoundShouldReturnError()
    {
        $request                    = new SubmitOrderAsRegisteredCustomerRequest();
        $request->customerId        = CustomerStub::ID;
        $request->selectedDelivery  = 999;
        $request->basketId          = BasketStub::ID;
        $request->paymentMethodId   = PaymentMethodRepositoryMock::COD_ID;
        $request->logisticPartnerId = LogisticPartnerRepositoryMock::DHL_ID;

        $result = $this->interactor->asRegisteredCustomer($request);

        $this->assertEquals($result::DELIVERY_ADDRESS_NOT_FOUND, $result->getCode());
    }

    public function testRegisteredCustomerOrderWhenBasketNotFoundShouldReturnError()
    {
        $selectedDeliveryAddress = new DeliveryAddressStub();
        $customer                = new CustomerStub();
        $selectedDeliveryAddress->setCustomer($customer);
        $this->deliveryAddressRepository->truncate();
        $this->deliveryAddressRepository->save($selectedDeliveryAddress);

        $request                    = new SubmitOrderAsRegisteredCustomerRequest();
        $request->customerId        = CustomerStub::ID;
        $request->selectedDelivery  = DeliveryAddressStub::ID;
        $request->basketId          = 888;
        $request->paymentMethodId   = PaymentMethodRepositoryMock::COD_ID;
        $request->logisticPartnerId = LogisticPartnerRepositoryMock::DHL_ID;

        $result = $this->interactor->asRegisteredCustomer($request);

        $this->assertEquals($result::BASKET_NOT_FOUND, $result->getCode());
    }

    public function testRegisteredCustomerOrderWhenPaymentMethodIdIsNullReturnError()
    {
        $selectedDeliveryAddress = new DeliveryAddressStub();
        $customer                = new CustomerStub();
        $selectedDeliveryAddress->setCustomer($customer);
        $this->deliveryAddressRepository->truncate();
        $this->deliveryAddressRepository->save($selectedDeliveryAddress);

        $request                   = new SubmitOrderAsRegisteredCustomerRequest();
        $request->customerId       = CustomerStub::ID;
        $request->selectedDelivery = DeliveryAddressStub::ID;
        $request->basketId         = BasketStub::ID;
        $request->paymentMethodId  = null;

        $result = $this->interactor->asRegisteredCustomer($request);

        $this->assertEquals($result::PAYMENT_METHOD_ID_INVALID, $result->getCode());
    }

    public function testRegisteredCustomerOrderWhenPaymentMethodIdIsZeroReturnError()
    {
        $selectedDeliveryAddress = new DeliveryAddressStub();
        $customer                = new CustomerStub();
        $selectedDeliveryAddress->setCustomer($customer);
        $this->deliveryAddressRepository->truncate();
        $this->deliveryAddressRepository->save($selectedDeliveryAddress);

        $request                   = new SubmitOrderAsRegisteredCustomerRequest();
        $request->customerId       = CustomerStub::ID;
        $request->selectedDelivery = DeliveryAddressStub::ID;
        $request->basketId         = BasketStub::ID;
        $request->paymentMethodId  = 0;

        $result = $this->interactor->asRegisteredCustomer($request);

        $this->assertEquals($result::PAYMENT_METHOD_NOT_FOUND, $result->getCode());
    }

    public function testRegisteredCustomerOrderWhenPaymentMethodNotFoundShouldReturnError()
    {
        $selectedDeliveryAddress = new DeliveryAddressStub();
        $customer                = new CustomerStub();
        $selectedDeliveryAddress->setCustomer($customer);
        $this->deliveryAddressRepository->truncate();
        $this->deliveryAddressRepository->save($selectedDeliveryAddress);

        $request                   = new SubmitOrderAsRegisteredCustomerRequest();
        $request->customerId       = CustomerStub::ID;
        $request->selectedDelivery = DeliveryAddressStub::ID;
        $request->basketId         = BasketStub::ID;
        $request->paymentMethodId  = 999;

        $result = $this->interactor->asRegisteredCustomer($request);

        $this->assertEquals($result::PAYMENT_METHOD_NOT_FOUND, $result->getCode());
    }

    public function testRegisteredCustomerOrderWhenLogisticPartnerNotFoundShouldReturnError()
    {
        $selectedDeliveryAddress = new DeliveryAddressStub();
        $customer                = new CustomerStub();
        $selectedDeliveryAddress->setCustomer($customer);
        $this->deliveryAddressRepository->truncate();
        $this->deliveryAddressRepository->save($selectedDeliveryAddress);

        $request                    = new SubmitOrderAsRegisteredCustomerRequest();
        $request->customerId        = CustomerStub::ID;
        $request->selectedDelivery  = DeliveryAddressStub::ID;
        $request->basketId          = BasketStub::ID;
        $request->paymentMethodId   = PaymentMethodRepositoryMock::COD_ID;
        $request->logisticPartnerId = 999;

        $result = $this->interactor->asRegisteredCustomer($request);

        $this->assertEquals($result::LOGISTIC_PARTNER_NOT_FOUND, $result->getCode());
    }

    public function testRegisteredCustomerOrderWhenOrderWasSavedShouldReturnOrderId()
    {
        $customer = new CustomerStub();
        $customer->setLastUsedInvoiceAddress(new InvoiceAddressStub());
        $customer->setLastUsedEmailAddress(new EmailAddressStub());
        $selectedDeliveryAddress = new DeliveryAddressStub();
        $selectedDeliveryAddress->setCustomer($customer);
        $this->customerRepository->truncate();
        $this->customerRepository->save($customer);
        $this->deliveryAddressRepository->truncate();
        $this->deliveryAddressRepository->save($selectedDeliveryAddress);

        $request                    = new SubmitOrderAsRegisteredCustomerRequest();
        $request->customerId        = CustomerStub::ID;
        $request->selectedDelivery  = DeliveryAddressStub::ID;
        $request->basketId          = BasketStub::ID;
        $request->paymentMethodId   = PaymentMethodRepositoryMock::COD_ID;
        $request->logisticPartnerId = LogisticPartnerRepositoryMock::DHL_ID;

        $result = $this->interactor->asRegisteredCustomer($request);

        $this->assertEquals($result::SUCCESS, $result->getCode());
    }
}
