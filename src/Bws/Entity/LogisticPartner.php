<?php

namespace Bws\Entity;

class LogisticPartner
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var integer
     */
    protected $id;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return LogisticPartner
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
 