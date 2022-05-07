<?php

namespace Packages\Models\Bot;

use Packages\Models\Bot\Calculators\CalculatorInterface;
use Packages\Models\Bot\Levels\BotLevel;
use Packages\Models\Othello\Board\Position\Position;
use Packages\Models\Othello\Othello\Othello;

interface BotInterface
{
    public function run(Othello $turn): Position;
}
