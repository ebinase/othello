<?php

namespace Packages\Domain\Color;

use http\Exception\InvalidArgumentException;

/**
 * Enum風に実装
 * TODO: enum化
 */
class Color
{
    const COLOR_WHITE = 1;
    const COLOR_BLACK = 2;

    private static $colorList = [
        self::COLOR_WHITE => '白',
        self::COLOR_BLACK => '黒',
    ];

    private $color;

    public function __construct($color)
    {
        if (!self::isColor($color)) throw new InvalidArgumentException();
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

    public function equals($color): bool
    {
        return $this->color == $color;
    }

    public function isOpposite($color): bool
    {
        return $color == $this->opposite()->toCode();
    }
}
