<?php

namespace Packages\Domain\Board\Position;

/**
 * 盤面上での位置を表すクラス
 */
class Position
{
    use PositionConverterTrait;

    /**
     * 盤面上の位置を座標IDの形式で保持する。
     * @var int
     */
    private int $positionId;

    public function __construct(int $position)
    {
        $this->positionId = $position;
    }

    public static function make(array|int $position): Position
    {
        // 数値の場合はpositionIDと判断
        if (is_int($position)) return new Position($position);
        // 配列の場合は[行, 列]の値と判断
        if (is_array($position)) return new Position(self::convertToPositionId($position));

        throw new \RuntimeException();
    }

    public function toPostionId(): int
    {
        return $this->positionId;
    }

    public function toMatrixPosition(): array
    {
        return self::convertToMatrixPosition($this->positionId);
    }
}
