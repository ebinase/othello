<?php

namespace Packages\Factories\Game;

use Illuminate\Support\Str;
use Packages\Models\Game\Game;
use Packages\Models\Game\GameMode;
use Packages\Models\Game\Participants;
use Packages\Models\Player\PlayerInterface;

class GameFactory
{
    public static function makeVsPlayerGame(PlayerInterface $whitePlayer, PlayerInterface $blackPlayer): Game
    {
        return Game::init(
            Str::uuid(),
            GameMode::vsPlayerMode(),
            Participants::make($whitePlayer, $blackPlayer)
        );
    }
}
