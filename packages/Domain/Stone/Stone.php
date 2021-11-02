<?php

namespace Packages\Domain\Stone;

use Packages\Domain\Color\Color;

/**
 * コマを表すクラス(仮)
 */
class Stone
{
    private $color;

    public function __construct($colorCode)
    {
        // HACK: 密結合だけど、後々enumに直す
        $this->color = new Color($colorCode);
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

    public function flip(): Stone
    {
        return new Stone($this->color->opposite());
    }

    public function equals(Color $color)
    {
        return $this->colorEquals($color->toCode());
    }
}
