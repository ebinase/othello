<?php

namespace Packages\Models\Bot\Calculators\Random;

use Packages\Models\Bot\Calculators\CalculatorInterface;
use Packages\Models\Turn\Turn;

class RandomCalculator implements CalculatorInterface
{
    private array $playablePositions;

    public function __construct(Turn $turn)
    {
        $board = $turn->getBoard();
        $color = $turn->getPlayableColor();
        $this->playablePositions = $board->playablePositions($color);
    }

    public function culculate(): int
    {
        $key = array_rand($this->playablePositions);
        return $this->playablePositions[$key];
    }
}
