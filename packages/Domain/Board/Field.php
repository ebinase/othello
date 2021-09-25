<?php

namespace Packages\Domain\Board;

class Field
{
    const FIELD_STATUS_EMPTY  = 0;
    const FIELD_STATUS_PLACED = 1;

    private $status;
    private $postion;
    private $stone;

    public function __construct($color, $postion)
    {
        
    }
}
