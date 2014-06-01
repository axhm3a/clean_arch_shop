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
}
 