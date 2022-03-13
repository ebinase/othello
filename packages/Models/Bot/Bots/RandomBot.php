<?php

namespace Packages\Models\Bot\Bots;

use Packages\Models\Board\Position\Position;
use Packages\Models\Bot\BotInterface;
use Packages\Models\Bot\Calculators\CalculatorInterface;
use Packages\Models\Bot\Calculators\Random\RandomCalculator;
use Packages\Models\Bot\Levels\BotLevel;
use Packages\Models\Bot\Levels\LevelFactory;
use Packages\Models\Turn\Turn;

class RandomBot implements BotInterface
{
    public function run(Turn $turn): Position
    {
        return RandomCalculator::culculate($turn);
    }
}
