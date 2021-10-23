<?php

namespace Packages\Domain\Bot\Strategies\Random;

use Packages\Domain\Board\Board;
use Packages\Domain\Bot\BaseBot;
use Packages\Domain\Color\Color;

class RandomBot extends BaseBot
{
    private array $playablePositions;

    public function __construct(Color $color, Board $board)
    {
        $this->playablePositions = $board->playablePositions($color);
    }

    public function culculate(): int
    {
        $key = array_rand($this->playablePositions);
        return $this->playablePositions[$key];
    }
}
