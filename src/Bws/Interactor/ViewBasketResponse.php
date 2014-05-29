<?php

namespace Bws\Interactor;

class ViewBasketResponse
{
    const SUCCESS          = 1;
    const BAD_BASKET_ID    = -1;
    const BASKET_NOT_FOUND = -2;

    private $code;
    private $message;

    private $positions;
    private $total;

    /**
     * @param string $message
     */
    public function __construct($code, $message, $positions = array(), $total = 0.0, $positionCount = 0)
    {
        $this->code      = $code;
        $this->message   = $message;
        $this->positions = $positions;
        $this->total     = $total;
        $this->posCount  = $positionCount;
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
     * @return mixed
     */
    public function getPositions()
    {
        return $this->positions;
    }

    /**
     * @return double
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getPositionCount()
    {
        return $this->posCount;
    }
}
 