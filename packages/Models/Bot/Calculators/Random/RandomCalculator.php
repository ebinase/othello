<?php

namespace Packages\Models\Bot\Calculators\Random;

use Packages\Models\Othello\Board\Position\Position;

class RandomCalculator
{
    public static function calculate(array $positions): Position
    {
        $key = array_rand($positions);
        return $positions[$key];
    }
}
