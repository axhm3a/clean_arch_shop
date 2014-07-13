<?php

namespace Bws\Entity;

class Customer
{
    /**
     * @var bool
     */
    protected $isRegistered = false;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var InvoiceAddress
     */
    protected $lastUsedInvoiceAddress;

    /**
     * @var EmailAddress
     */
    protected $lastUsedEmailAddress;

    /**
     * @var DeliveryAddress
     */
    protected $lastUsedDeliveryAddress;

    /**
     * @return bool
     */
    public function isRegistered()
    {
        return $this->isRegistered;
    }

    public function register()
    {
        $this->isRegistered = true;
    }

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
     * Set lastUsedInvoiceAddress
     *
     * @param InvoiceAddress $lastUsedInvoiceAddress
     *
     * @return Customer
     */
    public function setLastUsedInvoiceAddress(InvoiceAddress $lastUsedInvoiceAddress = null)
    {
        $this->lastUsedInvoiceAddress = $lastUsedInvoiceAddress;

        return $this;
    }

    /**
     * Get lastUsedInvoiceAddress
     *
     * @return InvoiceAddress
     */
    public function getLastUsedInvoiceAddress()
    {
        return $this->lastUsedInvoiceAddress;
    }

    /**
     * Set lastUsedEmailAddress
     *
     * @param EmailAddress $lastUsedEmailAddress
     *
     * @return Customer
     */
    public function setLastUsedEmailAddress(EmailAddress $lastUsedEmailAddress = null)
    {
        $this->lastUsedEmailAddress = $lastUsedEmailAddress;

        return $this;
    }

    /**
     * Get lastUsedEmailAddress
     *
     * @return EmailAddress
     */
    public function getLastUsedEmailAddress()
    {
        return $this->lastUsedEmailAddress;
    }

    /**
     * Set lastUsedDeliveryAddress
     *
     * @param DeliveryAddress $lastUsedDeliveryAddress
     *
     * @return Customer
     */
    public function setLastUsedDeliveryAddress(DeliveryAddress $lastUsedDeliveryAddress = null)
    {
        $this->lastUsedDeliveryAddress = $lastUsedDeliveryAddress;

        return $this;
    }

    /**
     * Get lastUsedDeliveryAddress
     *
     * @return DeliveryAddress
     */
    public function getLastUsedDeliveryAddress()
    {
        return $this->lastUsedDeliveryAddress;
    }
}
 