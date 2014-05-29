<?php

namespace Bws\Interactor;

class ViewBasketResponse
{
    const SUCCESS          = 1;
    const BAD_BASKET_ID    = -1;
    const BASKET_NOT_FOUND = -2;

    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $positions;

    /**
     * @var float
     */
    private $total;

    /**
     * @var int
     */
    private $posCount;

    /**
     * @param int    $code
     * @param string $message
     * @param array  $positions
     * @param float  $total
     * @param int    $positionCount
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
     * @return array
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
 