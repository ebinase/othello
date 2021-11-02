<?php

namespace Packages\Domain\Common\Position;

use http\Exception\InvalidArgumentException;

/**
 * Enum風に実装
 * TODO: enum化
 */
class Position
{
    const POSITION_TYPE_MATRIX = '01';
    const POSITION_TYPE_ID = '02';

    private $positionData;

    public function __construct($colorCode)
    {
        if (!self::isColor($colorCode)) throw new InvalidArgumentException();
        $this->color = $colorCode;
    }

    public function make($positionData, $dataType = self::POSITION_TYPE_MATRIX): Position
    {
        return new Position(($positionData));
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
