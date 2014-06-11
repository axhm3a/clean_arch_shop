<?php

namespace Bws\Interactor;

class SearchArticlesRequest
{
    /**
     * @var string
     */
    private $by;

    public function __construct($by)
    {
        $this->by = $by;
    }

    /**
     * @return string
     */
    public function getBy()
    {
        return $this->by;
    }
}