<?php

namespace Bws\Entity;

/**
 * Giftcard
 */
class Giftcard
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set code
     *
     * @param string $code
     * @return Giftcard
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return Giftcard
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
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
