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
        return $this->color->toCode() == $color;
    }

    public function isOppositeColor($color): bool
    {
        return $color == $this->color->opposite()->toCode();
    }

    public function colorCode()
    {
        return $this->color->toCode();
    }

    public function color(): Color
    {
        return $this->color;
    }

    public function opposite(): Stone
    {
        return new Stone($this->color->opposite(), $this->position);
    }

    public function move($step, $direction): Stone
    {
        return new Stone($this->color, $this->position->move($step, $direction));
    }

    public function position(): Position
    {
        return $this->position;
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
