<?php

namespace Bws\Interactor;

use Bws\Entity\Basket;
use Bws\Entity\Customer;
use Bws\Entity\DeliveryAddress;
use Bws\Entity\EmailAddress;
use Bws\Entity\EmailAddressStub;
use Bws\Entity\InvoiceAddress;
use Bws\Entity\LogisticPartner;
use Bws\Entity\Order;
use Bws\Entity\PaymentMethod;
use Bws\Repository\BasketRepository;
use Bws\Repository\CustomerRepository;
use Bws\Repository\DeliveryAddressRepository;
use Bws\Repository\EmailAddressRepository;
use Bws\Repository\InvoiceAddressRepository;
use Bws\Repository\LogisticPartnerRepository;
use Bws\Repository\OrderRepository;
use Bws\Repository\PaymentMethodRepository;

class SubmitOrder
{
    /**
     * @var \Bws\Repository\InvoiceAddressRepository
     */
    private $invoiceAddressRepository;

    /**
     * @var \Bws\Repository\DeliveryAddressRepository
     */
    private $deliveryAddressRepository;

    /**
     * @var \Bws\Repository\BasketRepository
     */
    private $basketRepository;

    /**
     * @var \Bws\Repository\OrderRepository
     */
    private $orderRepository;

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * @var EmailAddressRepository
     */
    private $emailAddressRepository;

    /**
     * @var PaymentMethodRepository
     */
    private $paymentMethodRepository;

    /**
     * @var LogisticPartnerRepository
     */
    private $logisticPartnerRepository;

    /**
     * @var PresentCurrentAddress
     */
    private $presentCurrentAddress;

    public function __construct(
        InvoiceAddressRepository $invoiceAddressRepository,
        DeliveryAddressRepository $deliveryAddressRepository,
        BasketRepository $basketRepository,
        OrderRepository $orderRepository,
        CustomerRepository $customerRepository,
        EmailAddressRepository $emailAddressRepository,
        PaymentMethodRepository $paymentMethodRepository,
        LogisticPartnerRepository $logisticPartnerRepository,
        PresentCurrentAddress $presentCurrentAddress
    ) {
        $this->invoiceAddressRepository  = $invoiceAddressRepository;
        $this->deliveryAddressRepository = $deliveryAddressRepository;
        $this->basketRepository          = $basketRepository;
        $this->orderRepository           = $orderRepository;
        $this->customerRepository        = $customerRepository;
        $this->emailAddressRepository    = $emailAddressRepository;
        $this->paymentMethodRepository   = $paymentMethodRepository;
        $this->logisticPartnerRepository = $logisticPartnerRepository;
        $this->presentCurrentAddress     = $presentCurrentAddress;
    }

    /**
     * @param SubmitOrderAsUnregisteredCustomerRequest $request
     *
     * @return SubmitOrderResponse
     */
    public function asUnregisteredCustomer(SubmitOrderAsUnregisteredCustomerRequest $request)
    {
        $invoiceAddress  = $this->saveInvoiceAddress($request);
        $deliveryAddress = $this->saveDeliveryAddress($request);
        $basket          = $this->basketRepository->find($request->basketId);
        $customer        = $this->saveCustomer($deliveryAddress, $invoiceAddress, $request->registering);
        $email           = $this->saveEmailAddress($request->emailAddress, $customer);
        $paymentMethod   = $this->paymentMethodRepository->find($request->paymentMethodId);
        $logisticPartner = $this->logisticPartnerRepository->find($request->logisticPartnerId);

        $this->updateCustomersEmailAddressRelation($customer, $email);
        $this->updateInvoiceAddressCustomerRelation($invoiceAddress, $customer);
        $this->updateDeliveryAddressCustomerRelation($deliveryAddress, $customer);

        $order = $this->saveOrder(
            $invoiceAddress,
            $deliveryAddress,
            $basket,
            $customer,
            $email,
            $paymentMethod,
            $logisticPartner
        );

        return new SubmitOrderResponse(SubmitOrderResponse::SUCCESS, '', $order->getId());
    }

    /**
     * @param SubmitOrderAsRegisteredCustomerRequest $request
     *
     * @return SubmitOrderResponse
     */
    public function asRegisteredCustomer(SubmitOrderAsRegisteredCustomerRequest $request)
    {
        if (null === $request->paymentMethodId) {
            return new SubmitOrderResponse(SubmitOrderResponse::PAYMENT_METHOD_ID_INVALID);
        }

        if (!$customer = $this->customerRepository->find($request->customerId)) {
            return new SubmitOrderResponse(SubmitOrderResponse::CUSTOMER_NOT_FOUND);
        }

        $result = $this->presentCurrentAddress->getCurrentDeliveryAddress(
            $request->customerId,
            $request->selectedDelivery
        );

        if ($result->code == $result::DELIVERY_ADDRESS_NOT_FOUND) {
            return new SubmitOrderResponse(SubmitOrderResponse::DELIVERY_ADDRESS_NOT_FOUND);
        }

        if (!$basket = $this->basketRepository->find($request->basketId)) {
            return new SubmitOrderResponse(SubmitOrderResponse::BASKET_NOT_FOUND);
        }

        if (!$paymentMethod = $this->paymentMethodRepository->find($request->paymentMethodId)) {
            return new SubmitOrderResponse(SubmitOrderResponse::PAYMENT_METHOD_NOT_FOUND);
        }

        if (!$request->logisticPartnerId
            || !$logisticPartner = $this->logisticPartnerRepository->find($request->logisticPartnerId)
        ) {
            return new SubmitOrderResponse(SubmitOrderResponse::LOGISTIC_PARTNER_NOT_FOUND);
        }

        $order = $this->saveOrder(
            $customer->getLastUsedInvoiceAddress(),
            $this->presentCurrentAddress->getLastFetchedDeliveryAddress(),
            $basket,
            $customer,
            $customer->getLastUsedEmailAddress(),
            $paymentMethod,
            $logisticPartner
        );

        return new SubmitOrderResponse(SubmitOrderResponse::SUCCESS, '', $order->getId());
    }

    /**
     * @param SubmitOrderAsUnregisteredCustomerRequest $request
     *
     * @return InvoiceAddress
     */
    protected function saveInvoiceAddress(SubmitOrderAsUnregisteredCustomerRequest $request)
    {
        if (!$address = $this->invoiceAddressRepository->findExisting(
            $request->invoiceFirstName,
            $request->invoiceLastName,
            $request->invoiceStreet,
            $request->invoiceZip,
            $request->invoiceCity
        )
        ) {
            $address = $this->invoiceAddressRepository->factory();
            $address->setFirstName($request->invoiceFirstName);
            $address->setLastName($request->invoiceLastName);
            $address->setStreet($request->invoiceStreet);
            $address->setZip($request->invoiceZip);
            $address->setCity($request->invoiceCity);

            $this->invoiceAddressRepository->save($address);
        }

        return $address;
    }

    /**
     * @param SubmitOrderAsUnregisteredCustomerRequest $request
     *
     * @return DeliveryAddress
     */
    protected function saveDeliveryAddress(SubmitOrderAsUnregisteredCustomerRequest $request)
    {
        if (!$address = $this->deliveryAddressRepository->findExisting(
            $request->deliveryFirstName,
            $request->deliveryLastName,
            $request->deliveryStreet,
            $request->deliveryZip,
            $request->deliveryCity
        )
        ) {
            $address = $this->deliveryAddressRepository->factory();
            $address->setFirstName($request->deliveryFirstName);
            $address->setLastName($request->deliveryLastName);
            $address->setStreet($request->deliveryStreet);
            $address->setZip($request->deliveryZip);
            $address->setCity($request->deliveryCity);

            $this->deliveryAddressRepository->save($address);
        }

        return $address;
    }

    /**
     * @param InvoiceAddress  $invoiceAddress
     * @param DeliveryAddress $deliveryAddress
     * @param Basket          $basket
     * @param Customer        $customer
     * @param EmailAddress    $emailAddress
     * @param PaymentMethod   $paymentMethod
     * @param LogisticPartner $logisticPartner
     *
     * @return Order
     */
    protected function saveOrder(
        InvoiceAddress $invoiceAddress,
        DeliveryAddress $deliveryAddress,
        Basket $basket,
        Customer $customer,
        EmailAddress $emailAddress,
        PaymentMethod $paymentMethod,
        LogisticPartner $logisticPartner
    ) {
        $order = $this->orderRepository->factory();
        $order->setInvoiceAddress($invoiceAddress);
        $order->setDeliveryAddress($deliveryAddress);
        $order->setBasket($basket);
        $order->setCustomer($customer);
        $order->setEmailAddress($emailAddress);
        $order->setPaymentMethod($paymentMethod);
        $order->setLogisticPartner($logisticPartner);

        $this->orderRepository->save($order);

        return $order;
    }

    /**
     * @param string   $emailAddress
     * @param Customer $customer
     *
     * @return EmailAddress
     */
    protected function saveEmailAddress($emailAddress, Customer $customer)
    {
        if (!$email = $this->emailAddressRepository->findByAddress($emailAddress)) {
            $email = $this->emailAddressRepository->factory();
            $email->setAddress($emailAddress);
            $email->setCustomer($customer);
            $this->emailAddressRepository->save($email);
        }

        return $email;
    }

    /**
     * @param Customer     $customer
     * @param EmailAddress $email
     */
    protected function updateCustomersEmailAddressRelation(Customer $customer, EmailAddress $email)
    {
        $customer->setLastUsedEmailAddress($email);
        $this->customerRepository->save($customer);
    }

    /**
     * @param DeliveryAddress $deliveryAddress
     * @param InvoiceAddress  $invoiceAddress
     * @param bool            $registering
     *
     * @return Customer
     */
    protected function saveCustomer(DeliveryAddress $deliveryAddress, InvoiceAddress $invoiceAddress, $registering)
    {
        if (!$customer = $this->customerRepository->match($invoiceAddress)) {
            $customer = $this->customerRepository->factory();
            $customer->setCustomerString($invoiceAddress->getCustomerString());
        }

        $customer->setLastUsedDeliveryAddress($deliveryAddress);
        $customer->setLastUsedInvoiceAddress($invoiceAddress);

        if ($registering) {
            $customer->register();
        }

        $this->customerRepository->save($customer);
        return $customer;
    }

    /**
     * @param InvoiceAddress $invoiceAddress
     * @param Customer       $customer
     */
    protected function updateInvoiceAddressCustomerRelation(InvoiceAddress $invoiceAddress, Customer $customer)
    {
        $invoiceAddress->setCustomer($customer);
        $this->invoiceAddressRepository->save($invoiceAddress);
    }

    /**
     * @param DeliveryAddress $deliveryAddress
     * @param Customer        $customer
     */
    protected function updateDeliveryAddressCustomerRelation(DeliveryAddress $deliveryAddress, Customer $customer)
    {
        $deliveryAddress->setCustomer($customer);
        $this->deliveryAddressRepository->save($deliveryAddress);
    }
}
 