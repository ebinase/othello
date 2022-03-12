<?php

namespace Packages\Models\Bot;

use Packages\Models\Board\Position\Position;
use Packages\Models\Bot\Calculators\CalculatorInterface;
use Packages\Models\Bot\Levels\BotLevel;
use Packages\Models\Turn\Turn;

interface BotInterface
{
    public function run(Turn $turn): Position;
}
