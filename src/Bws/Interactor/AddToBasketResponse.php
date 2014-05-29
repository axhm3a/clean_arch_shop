<?php

namespace Bws\Interactor;

class AddToBasketResponse
{
    const SUCCESS           = 1;
    const ARTICLE_NOT_FOUND = -1;
    const BAD_BASKET_ID     = -2;
    const ZERO_COUNT        = -3;
    const BAD_ARTICLE_ID    = -4;

    private $code;
    private $message;

    private $basketId;
    private $total;
    private $posCount;

    /**
     * @param string $message
     */
    public function __construct($code, $message, $basketId = 0, $total = 0.0, $posCount = 0)
    {
        $this->code     = $code;
        $this->message  = $message;
        $this->basketId = $basketId;
        $this->total    = $total;
        $this->posCount = $posCount;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getBasketId()
    {
        return $this->basketId;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getPosCount()
    {
        return $this->posCount;
    }


}
 