<?php

namespace Packages\Domain\Color;

/**
 * Enum風に実装
 */
class Color
{
    const COLOR_WHITE = 1;
    const COLOR_BLACK = 2;

    private $colorList = [
        self::COLOR_WHITE => '白',
        self::COLOR_WHITE => '黒',
    ];

    private $color;

    public function __construct($color)
    {
        $this->color = $color;
    }

    public function toCode()
    {
        return $this->color;
    }

    public function opposite(): Color
    {
        foreach($this->colorList as $colorCode => $colorName) {
            if ($colorCode != $this->color) {
                return new Color($colorCode);
            }
        }
    }
}