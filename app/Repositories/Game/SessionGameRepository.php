<?php
namespace App\Repositories\Game;

use Packages\Models\Game\Game;
use Packages\Repositories\Game\GameRepositoryInterface;

class SessionGameRepository implements GameRepositoryInterface
{
    const SESSION_STORE_KEY_GAME_DATA = 'game_data';

    /**
     * ゲーム情報を取得する
     *
     * @param string|null $gameId sessionの性質上idが無くてもゲーム情報が一意に絞り込めるので不要
     * @return Game
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function find(string $gameId = null): Game
    {
        $gameData = unserialize(session()->get(self::SESSION_STORE_KEY_GAME_DATA));
        if ($gameData instanceof Game) {
            return $gameData;
        }
        // TODO:例外処理
        throw new \Exception();
    }

    public function save(Game $game): void
    {
        session()->put(self::SESSION_STORE_KEY_GAME_DATA, serialize($game));
    }
}
