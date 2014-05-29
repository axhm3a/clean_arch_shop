<?php

namespace Bws\Interactor;

class ViewBasketRequest 
{
    private $basketId;

    public function __construct($basketId)
    {
        $this->basketId = $basketId;
    }

    /**
     * @return integer
     */
    public function getBasketId()
    {
        return $this->basketId;
    }




}
 