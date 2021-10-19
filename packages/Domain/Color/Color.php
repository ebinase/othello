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

    public static function white(): Color
    {
        return new Color(self::COLOR_WHITE);
    }

    public static function black(): Color
    {
        return new Color(self::COLOR_BLACK);
    }

    public function make($colorCode): Color
    {
        return new Color($colorCode);
    }

    public function __construct($colorCode)
    {
        if (!self::isColor($colorCode)) throw new InvalidArgumentException();
        $this->color = $colorCode;
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
