<?php

namespace Packages\Domain\Common\Position;

trait PositionConverterTrait
{
    private int $_positionConverterRows = 8;
    private int $_positionConverterColumns = 8;

    public function toMatrix(string|int $positionId): ?array
    {
        if ($positionId < 1 || $positionId > $this->_positionConverterRows * $this->_positionConverterColumns) {
            return null;
        }

        // 行
        $row = (int)floor($positionId / $this->_positionConverterRows);
        // 列
        $column = $positionId % $this->_positionConverterColumns;

        if ($column === 0) {
            // 割り切れる場合は最後の列を指定
            $column = $this->_positionConverterColumns;
        } else {
            // 割り切れない場合は行番号を1スタートにするために+1 (1~7は0+1行目, 8はそのまま1行目)
            $row += 1;
        }
        return [$row, $column];
    }

    public function toId(array $matrixPosition): string|int|null
    {
        $matrixPosition = array_values($matrixPosition);
        foreach ($matrixPosition as $value) {
            if ($value < 1) return null;
        }

        if ($matrixPosition[0] > $this->_positionConverterRows) return null;
        if ($matrixPosition[1] > $this->_positionConverterColumns) return null;

        return ($matrixPosition[0] -1 ) * $this->_positionConverterRows + $matrixPosition[1];
    }
}
