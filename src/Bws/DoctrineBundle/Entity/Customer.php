<?php

namespace Bws\DoctrineBundle\Entity;

/**
 * Customer
 */
class Customer
{
    /**
     * @var integer
     */
    private $id;


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
