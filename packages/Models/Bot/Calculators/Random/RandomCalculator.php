<?php

namespace Packages\Models\Bot\Calculators\Random;

use Packages\Models\Board\Position\Position;
use Packages\Models\Bot\Calculators\CalculatorInterface;
use Packages\Models\Turn\Turn;

class RandomCalculator implements CalculatorInterface
{
    public static function culculate(Turn $turn): Position
    {
        $board = $turn->getBoard();
        $color = $turn->getPlayableColor();
        $playablePositions = $board->playablePositions($color);

        $key = array_rand($playablePositions);
        return Position::make($playablePositions[$key]);
    }
}
