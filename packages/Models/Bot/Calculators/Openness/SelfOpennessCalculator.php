<?php

namespace Packages\Models\Bot\Calculators\Openness;

use Packages\Models\Bot\Calculators\CalculatorInterface;
use Packages\Models\Common\Matrix\Matrix;
use Packages\Models\Othello\Board\Board;
use Packages\Models\Othello\Board\Color\Color;
use Packages\Models\Othello\Board\Position\Position;
use Packages\Models\Othello\Othello\Othello;

class SelfOpennessCalculator
{
    /**
     * @param Othello $turn
     * @return array{openness:int, positions:array<Position>}
     */
    public static function calculate(Othello $turn): array
   {
       $board = $turn->getBoard();
       $color = $turn->getPlayableColor();

       $result = [];
       foreach ($board->playablePositions($color) as $position) {
           $openness = self::getSelfOpenness($board, $position, $color);
           $result[$openness][] = $position;
       }
       return $result;
   }

    public static function getSelfOpenness(Board $board, Position $targetPosition, Color $color): int
    {
        // 置けない場所の場合は開放度0
        if (!$board->isValid($targetPosition, $color)) return 0;

        // 計算用にMatrixクラス呼び出し
        $boardMatrix = Matrix::make($board->toArray());

        // 指定された位置の周辺のマスに空きがいくつあるか計算
        $surroundings = $boardMatrix->getSuroundings($targetPosition->toMatrixPosition());
        $emptyFields = array_filter($surroundings, fn($field) => $field === Board::BOARD_EMPTY);
        return count($emptyFields);
    }
}
