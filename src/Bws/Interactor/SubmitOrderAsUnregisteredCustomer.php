<?php

namespace Bws\Interactor;

use Bws\Entity\Basket;
use Bws\Entity\DeliveryAddress;
use Bws\Entity\InvoiceAddress;
use Bws\Repository\BasketRepository;
use Bws\Repository\DeliveryAddressRepository;
use Bws\Repository\InvoiceAddressRepository;
use Bws\Repository\OrderRepository;

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
     * @param InvoiceAddressRepository  $invoiceAddressRepository
     * @param DeliveryAddressRepository $deliveryAddressRepository
     * @param BasketRepository          $basketRepository
     * @param OrderRepository           $orderRepository
     */
    public function __construct(
        InvoiceAddressRepository $invoiceAddressRepository,
        DeliveryAddressRepository $deliveryAddressRepository,
        BasketRepository $basketRepository,
        OrderRepository $orderRepository
    ) {
        $this->invoiceAddressRepository  = $invoiceAddressRepository;
        $this->deliveryAddressRepository = $deliveryAddressRepository;
        $this->basketRepository          = $basketRepository;
        $this->orderRepository           = $orderRepository;
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
        $order           = $this->saveOrder($invoiceAddress, $deliveryAddress, $basket);

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
     *
     * @return \Bws\Entity\Order
     */
    protected function saveOrder(InvoiceAddress $invoiceAddress, DeliveryAddress $deliveryAddress, Basket $basket)
    {
        $order = $this->orderRepository->factory();
        $order->setInvoiceAddress($invoiceAddress);
        $order->setDeliveryAddress($deliveryAddress);
        $order->setBasket($basket);

        $this->orderRepository->save($order);

        return $order;
    }
}
 