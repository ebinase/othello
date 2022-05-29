<?php

namespace Packages\Models\Bot;

use Packages\Models\Bot\Calculators\CalculatorInterface;
use Packages\Models\Bot\Levels\BotLevel;
use Packages\Models\Core\Board\Position\Position;
use Packages\Models\Core\Othello\Othello;

interface BotInterface
{
    public function run(Othello $turn): Position;
}
