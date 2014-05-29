<?php

namespace Bws\Interactor;

class ViewBasketRequest 
{
    /**
     * @var int
     */
    private $basketId;

    /**
     * @param int $basketId
     */
    public function __construct($basketId)
    {
        $this->basketId = $basketId;
    }

    /**
     * @return int
     */
    public function getBasketId()
    {
        return $this->basketId;
    }
}
 