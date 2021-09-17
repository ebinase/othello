<?php

namespace Packages\Domain\Stone;

use Packages\Domain\Color\Color;
use Packages\Domain\Position\Position;

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
        $this->color = $color;
        $this->position = $position;
    }

    public function colorEquals($color): bool
    {
        return $this->color === $color;
    }

    public function colorCode()
    {
        return $this->color->toCode();
    }

    public function move($step, $direction): Stone
    {
        return new Stone($this->color, $this->position->move($step, $direction));
    }


    // TODO: PositionService(仮)に移動？
    public function positionsInMove($step, $direction): array
    {
        return $this->position->positionsInMove($step, $direction);
    }



    public function x(): int
    {
        return $this->position->x();
    }

    public function y(): int
    {
        return $this->position->x();
    }
}