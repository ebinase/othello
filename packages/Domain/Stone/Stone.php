<?php

namespace Packages\Domain\Stone;

use Packages\Domain\Position\Position;
use Packages\Domain\Color\Color;

/**
 * コマを表すクラス(仮)
 * 色をenumにするか、座標情報も持たせるか、など検討
 */
class Stone
{
    private $color;
    private $position;

    public function __construct(Color $color, Position $position)
    {
        //
    }

}