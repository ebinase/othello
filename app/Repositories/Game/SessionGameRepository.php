<?php
namespace App\Repositories\Game;

use Packages\Models\GameOrganizer\Game;
use Packages\Models\GameOrganizer\GameRepositoryInterface;

class SessionGameRepository implements GameRepositoryInterface
{
    const SESSION_STORE_KEY_GAME_DATA = 'game_data';

    /**
     * ゲーム情報を取得する
     *
     * @param string|null $gameId
     * @return Game
     */
    public function findById(string $gameId = null): ?Game
    {
        $gameData = unserialize(session()->get(self::SESSION_STORE_KEY_GAME_DATA));
        if ($gameData instanceof Game) {
            return $gameData;
        }

        return null;
    }

    public function save(Game $game): void
    {
        session()->put(self::SESSION_STORE_KEY_GAME_DATA, serialize($game));
    }
}
