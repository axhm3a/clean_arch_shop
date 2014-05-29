<?php

namespace Bws\DoctrineBundle\Entity;

/**
 * Order
 */
class Order
{
    /**
     * @var integer
     */
    private $basketId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set basketId
     *
     * @param integer $basketId
     * @return Order
     */
    public function setBasketId($basketId)
    {
        $this->basketId = $basketId;

        return $this;
    }

    /**
     * Get basketId
     *
     * @return integer 
     */
    public function getBasketId()
    {
        return $this->basketId;
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
}
