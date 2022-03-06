<?php
namespace App\Repositories\Game;

use Packages\Models\Game\Game;
use Packages\Models\Game\GameMode;
use Packages\Models\Game\Participants;
use Packages\Models\Player\Player;
use Packages\Repositories\Game\GameRepositoryInterface;

class GameRepository implements GameRepositoryInterface
{
    public function find(string $gameId): Game
    {
        // TODO: Implement find() method.
    }

    public function save(Game $game): void
    {
        // TODO: Implement save() method.
    }
}
