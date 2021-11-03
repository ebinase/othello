<?php

namespace Packages\Domain\Board\Position;

use Packages\Domain\Board\Board;

trait PositionConverterTrait
{
    public static function convertToMatrixPosition(int $positionId): ?array
    {
        // HACK: Boardの値を使用しても依存関係は問題ない？
        if ($positionId < 1 || $positionId > Board::BOARD_SIZE_ROWS * Board::BOARD_SIZE_COLS) {
            return null;
        }

        // 行
        $row = (int)floor($positionId / Board::BOARD_SIZE_ROWS);
        // 列
        $column = $positionId % Board::BOARD_SIZE_COLS;

        if ($column === 0) {
            // 割り切れる場合は最後の列を指定
            $column = Board::BOARD_SIZE_COLS;
        } else {
            // 割り切れない場合は行番号を1スタートにするために+1 (1~7は0+1行目, 8はそのまま1行目)
            $row += 1;
        }
        return [$row, $column];
    }

    public static function convertToPositionId(array $matrixPosition): ?int
    {
        $matrixPosition = array_values($matrixPosition);
        foreach ($matrixPosition as $value) {
            if ($value < 1) return null;
        }

        if ($matrixPosition[0] > Board::BOARD_SIZE_ROWS) return null;
        if ($matrixPosition[1] > Board::BOARD_SIZE_COLS) return null;

        return ($matrixPosition[0] -1 ) * Board::BOARD_SIZE_ROWS + $matrixPosition[1];
    }
}
