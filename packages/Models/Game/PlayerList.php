<?php

namespace Packages\Models\Game;

use Packages\Models\Player\PlayerInterface;

class PlayerList
{
    /**
     * @param PlayerInterface[] $players
     */
    private function __construct(
        private array $players
    )
    {}

    /**
     * @param PlayerInterface[] $players
     * @return PlayerList
     */
    public static function make(array $players)
    {
        return new PlayerList($players);
    }

}
