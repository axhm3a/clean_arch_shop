<?php

namespace Bws\Interactor;

class SubmitOrderAsUnregisteredCustomerRequest 
{
    public $invoiceFirstName;
    public $invoiceLastName;
    public $invoiceStreet;
    public $invoiceZip;
    public $invoiceCity;

    public $deliveryFirstName;
    public $deliveryLastName;
    public $deliveryStreet;
    public $deliveryZip;
    public $deliveryCity;

    public $paymentMethodId;
    public $logisticPartnerId;

    public $basketId;
}
 