<?php

namespace Bws\Interactor;

class AddDeliveryAddressResponse
{
    const SUCCESS = 1;

    const CUSTOMER_NOT_FOUND = -1;

    /**
     * @var int
     */
    public $code;
}
 