<?php

namespace Bws\Entity;

class Order
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var InvoiceAddress
     */
    protected $invoiceAddress;

    /**
     * @var DeliveryAddress
     */
    protected $deliveryAddress;

    /**
     * @var Basket
     */
    protected $basket;

    /**
     * @var \Bws\DoctrineBundle\Entity\Customer
     */
    protected $customer;

    /**
     * @var \Bws\DoctrineBundle\Entity\EmailAddress
     */
    protected $emailAddress;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set invoiceAddress
     *
     * @param InvoiceAddress $invoiceAddress
     *
     * @return Order
     */
    public function setInvoiceAddress(InvoiceAddress $invoiceAddress = null)
    {
        $this->invoiceAddress = $invoiceAddress;

        return $this;
    }

    /**
     * Get invoiceAddress
     *
     * @return \Bws\DoctrineBundle\Entity\InvoiceAddress
     */
    public function getInvoiceAddress()
    {
        return $this->invoiceAddress;
    }

    /**
     * Set deliveryAddress
     *
     * @param DeliveryAddress $deliveryAddress
     *
     * @return Order
     */
    public function setDeliveryAddress(DeliveryAddress $deliveryAddress = null)
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    /**
     * Get deliveryAddress
     *
     * @return \Bws\DoctrineBundle\Entity\DeliveryAddress
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    /**
     * Set basket
     *
     * @param Basket $basket
     *
     * @return Order
     */
    public function setBasket(Basket $basket = null)
    {
        $this->basket = $basket;

        return $this;
    }

    /**
     * Get basket
     *
     * @return \Bws\DoctrineBundle\Entity\Basket
     */
    public function getBasket()
    {
        return $this->basket;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set customer
     *
     * @param Customer $customer
     *
     * @return Order
     */
    public function setCustomer(Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set emailAddress
     *
     * @param EmailAddress $emailAddress
     *
     * @return Order
     */
    public function setEmailAddress(EmailAddress $emailAddress = null)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return EmailAddress
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }
}
 