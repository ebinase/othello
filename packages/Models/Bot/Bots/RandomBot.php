<?php

namespace Packages\Models\Bot\Bots;

use Packages\Models\Bot\BotInterface;
use Packages\Models\Bot\Calculators\Random\RandomCalculator;
use Packages\Models\Othello\Board\Position\Position;
use Packages\Models\Othello\Turn\Turn;

class RandomBot implements BotInterface
{
    public function run(Turn $turn): Position
    {
        $board = $turn->getBoard();
        $color = $turn->getPlayableColor();
        $playablePositions = $board->playablePositions($color);

        return RandomCalculator::calculate($playablePositions);
    }
}
