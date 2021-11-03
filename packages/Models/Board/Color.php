<?php

namespace Packages\Models\Board;

/**
 * Enum風に実装
 * TODO: enum化
 */
class Color
{
    const COLOR_CODE_WHITE = '01';
    const COLOR_CODE_BLACK = '02';

    private static array $colorNameList = [
        self::COLOR_CODE_WHITE => '白',
        self::COLOR_CODE_BLACK => '黒',
    ];

    private string $colorCode;

    public function __construct(string $colorCode)
    {
        if (!self::isColor($colorCode)) throw new \RuntimeException();
        $this->colorCode = $colorCode;
    }

    public static function white(): Color
    {
        return new Color(self::COLOR_CODE_WHITE);
    }

    public static function black(): Color
    {
        return new Color(self::COLOR_CODE_BLACK);
    }

    public static function make($colorCode): Color
    {
        return new Color($colorCode);
    }

    public static function isColor($color): bool
    {
        return key_exists($color, self::$colorNameList);
    }

    public function toCode(): string
    {
        return $this->colorCode;
    }

    public function opposite(): Color
    {
        $oppositeColor = $this->colorCode == self::COLOR_CODE_WHITE ? self::COLOR_CODE_BLACK : self::COLOR_CODE_WHITE;
        return new Color($oppositeColor);
    }

    public function equals(Color $color): bool
    {
        return $this->colorCode === $color->toCode();
    }

    public function isOpposite(Color $color): bool
    {
        return $this->opposite()->toCode() === $color->toCode();
    }

    public function codeEquals(string $colorCode): bool
    {
        return $this->colorCode === $colorCode;
    }

    public function isOppositeCode(string $colorCode): bool
    {
        return $this->opposite()->toCode() === $colorCode;
    }
}
