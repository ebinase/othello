<?php

namespace Packages\Domain\Color;

/**
 * Enum風に実装
 */
class Color
{
    const COLOR_WHITE = 1;
    const COLOR_BLACK = 2;

    private static $colorList = [
        self::COLOR_WHITE => '白',
        self::COLOR_WHITE => '黒',
    ];

    private $color;

    public function __construct($color)
    {
        $this->color = $color;
    }

    public static function isColor($color): bool
    {
        return key_exists($color, self::$colorList);
    }

    public function toCode()
    {
        return $this->color;
    }

    public function opposite(): Color
    {
        $oppositeColor = $this->color == self::COLOR_WHITE ? self::COLOR_BLACK : self::COLOR_WHITE;
        return new Color($oppositeColor);
    }
}