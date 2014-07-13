<?php

namespace Bws\Interactor;

use Bws\Entity\Basket;
use Bws\Entity\Customer;
use Bws\Entity\DeliveryAddress;
use Bws\Entity\EmailAddress;
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

class SubmitOrderAsUnregisteredCustomer
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

    private $paymentMethodRepository;

    private $logisticPartnerRepository;

    /**
     * @param InvoiceAddressRepository  $invoiceAddressRepository
     * @param DeliveryAddressRepository $deliveryAddressRepository
     * @param BasketRepository          $basketRepository
     * @param OrderRepository           $orderRepository
     * @param CustomerRepository        $customerRepository
     * @param EmailAddressRepository    $emailAddressRepository
     * @param PaymentMethodRepository   $paymentMethodRepository
     * @param LogisticPartnerRepository $logisticPartnerRepository
     */
    public function __construct(
        InvoiceAddressRepository $invoiceAddressRepository,
        DeliveryAddressRepository $deliveryAddressRepository,
        BasketRepository $basketRepository,
        OrderRepository $orderRepository,
        CustomerRepository $customerRepository,
        EmailAddressRepository $emailAddressRepository,
        PaymentMethodRepository $paymentMethodRepository,
        LogisticPartnerRepository $logisticPartnerRepository
    ) {
        $this->invoiceAddressRepository  = $invoiceAddressRepository;
        $this->deliveryAddressRepository = $deliveryAddressRepository;
        $this->basketRepository          = $basketRepository;
        $this->orderRepository           = $orderRepository;
        $this->customerRepository        = $customerRepository;
        $this->emailAddressRepository    = $emailAddressRepository;
        $this->paymentMethodRepository   = $paymentMethodRepository;
        $this->logisticPartnerRepository = $logisticPartnerRepository;
    }

    /**
     * @param SubmitOrderAsUnregisteredCustomerRequest $request
     *
     * @return SubmitOrderResponse
     */
    public function execute(SubmitOrderAsUnregisteredCustomerRequest $request)
    {
        $invoiceAddress  = $this->saveInvoiceAddress($request);
        $deliveryAddress = $this->saveDeliveryAddress($request);
        $basket          = $this->basketRepository->find($request->basketId);

        $customer = $this->customerRepository->factory();
        $customer->setLastUsedDeliveryAddress($deliveryAddress);
        $customer->setLastUsedInvoiceAddress($invoiceAddress);
        $this->customerRepository->save($customer);

        $email = $this->emailAddressRepository->factory();
        $email->setAddress($request->emailAddress);
        $email->setCustomer($customer);
        $this->emailAddressRepository->save($email);

        $customer->setLastUsedEmailAddress($email);
        $this->customerRepository->save($customer);

        $invoiceAddress->setCustomer($customer);
        $this->invoiceAddressRepository->save($invoiceAddress);

        $deliveryAddress->setCustomer($customer);
        $this->deliveryAddressRepository->save($deliveryAddress);

        $paymentMethod   = $this->paymentMethodRepository->find($request->paymentMethodId);
        $logisticPartner = $this->logisticPartnerRepository->find($request->logisticPartnerId);

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
     * @param SubmitOrderAsUnregisteredCustomerRequest $request
     *
     * @return \Bws\Entity\InvoiceAddress
     */
    protected function saveInvoiceAddress(SubmitOrderAsUnregisteredCustomerRequest $request)
    {
        $address = $this->invoiceAddressRepository->factory();
        $address->setFirstName($request->invoiceFirstName);
        $address->setLastName($request->invoiceLastName);
        $address->setStreet($request->invoiceStreet);
        $address->setZip($request->invoiceZip);
        $address->setCity($request->invoiceCity);

        $this->invoiceAddressRepository->save($address);

        return $address;
    }

    /**
     * @param SubmitOrderAsUnregisteredCustomerRequest $request
     *
     * @return \Bws\Entity\DeliveryAddress
     */
    protected function saveDeliveryAddress(SubmitOrderAsUnregisteredCustomerRequest $request)
    {
        $address = $this->deliveryAddressRepository->factory();
        $address->setFirstName($request->deliveryFirstName);
        $address->setLastName($request->deliveryLastName);
        $address->setStreet($request->deliveryStreet);
        $address->setZip($request->deliveryZip);
        $address->setCity($request->deliveryCity);

        $this->deliveryAddressRepository->save($address);

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
}
 