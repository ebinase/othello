<?php

namespace Packages\UseCases\Game;

use Illuminate\Support\Str;
use Packages\Models\Game\Game;
use Packages\Models\Game\GameMode;
use Packages\Models\Game\Participants;
use Packages\Models\Player\Player;

class GameInitializeUsecase
{
    /**
     * @return Game
     */
    public function initialize(): Game
    {
        // todo: 適切なクラスに移動
        $gameId = Str::uuid();
        $whitePlayer = new Player('01', 'player_white');
        $blackPlayer = new Player('02', 'player_black');
        return Game::init($gameId, GameMode::vsPlayerMode(), Participants::make($whitePlayer, $blackPlayer));
    }
}
