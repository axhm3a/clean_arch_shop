<?php

namespace Bws\Entity;

use ArrayAccess;

class Basket
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var ArrayAccess
     */
    protected $basketPositions;

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
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param ArrayAccess $basketPositions
     */
    public function setBasketPositions($basketPositions)
    {
        $this->basketPositions = $basketPositions;
    }

    /**
     * @return ArrayAccess
     */
    public function getPositions()
    {
        return $this->basketPositions;
    }
}
