<?php

namespace Packages\Domain\Color;

use http\Exception\InvalidArgumentException;

/**
 * Enum風に実装
 * TODO: enum化
 */
class Color
{
//    const COLOR_WHITE = '01';
//    const COLOR_BLACK = '02';
    const COLOR_WHITE = 1;
    const COLOR_BLACK = 2;

    private static $colorValueList = [
        self::COLOR_WHITE => 1,
        self::COLOR_BLACK => 2,
    ];

    private static $colorNameList = [
        self::COLOR_WHITE => '白',
        self::COLOR_BLACK => '黒',
    ];

    private $colorCode;

    public function __construct($colorCode)
    {
        if (!self::isColor($colorCode)) throw new InvalidArgumentException();
        $this->colorCode = $colorCode;
    }

    public static function white(): Color
    {
        return new Color(self::COLOR_WHITE);
    }

    public static function black(): Color
    {
        return new Color(self::COLOR_BLACK);
    }

    public static function make($colorCode): Color
    {
        return new Color($colorCode);
    }

    public static function isColor($color): bool
    {
        return key_exists($color, self::$colorValueList);
    }

    public function toCode()
    {
        // todo: valueに置き換え
        return $this->colorCode;
    }

    public function toValue()
    {

    }

    public function opposite(): Color
    {
        $oppositeColor = $this->colorCode == self::COLOR_WHITE ? self::COLOR_BLACK : self::COLOR_WHITE;
        return new Color($oppositeColor);
    }

    public function equals($color): bool
    {
        return $this->colorCode == $color;
    }

    public function isOpposite($color): bool
    {
        return $color == $this->opposite()->toCode();
    }
}
