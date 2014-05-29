<?php

namespace Bws\DoctrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Voucher
 */
class Voucher
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var float
     */
    private $reductionMonetary;

    /**
     * @var float
     */
    private $reductionPercent;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set code
     *
     * @param string $code
     * @return Voucher
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
     * Set reductionMonetary
     *
     * @param float $reductionMonetary
     * @return Voucher
     */
    public function setReductionMonetary($reductionMonetary)
    {
        $this->reductionMonetary = $reductionMonetary;

        return $this;
    }

    /**
     * Get reductionMonetary
     *
     * @return float 
     */
    public function getReductionMonetary()
    {
        return $this->reductionMonetary;
    }

    /**
     * Set reductionPercent
     *
     * @param float $reductionPercent
     * @return Voucher
     */
    public function setReductionPercent($reductionPercent)
    {
        $this->reductionPercent = $reductionPercent;

        return $this;
    }

    /**
     * Get reductionPercent
     *
     * @return float 
     */
    public function getReductionPercent()
    {
        return $this->reductionPercent;
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
