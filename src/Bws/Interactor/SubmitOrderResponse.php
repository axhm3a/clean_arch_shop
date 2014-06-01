<?php

namespace Bws\Interactor;

class SubmitOrderResponse
{
    const SUCCESS = 1;

    /**
     * @var integer
     */
    private $code;

    /**
     * @var string
     */
    private $message;

    /**
     * @var integer
     */
    private $orderId;

    /**
     * @param integer $code
     * @param string  $message
     * @param integer $orderId
     */
    public function __construct($code, $message, $orderId)
    {
        $this->code    = $code;
        $this->message = $message;
        $this->orderId = $orderId;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }
}
 