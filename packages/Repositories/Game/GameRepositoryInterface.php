<?php

namespace Packages\Repositories\Game;

use Packages\Models\Game\Game;

interface GameRepositoryInterface
{
    // ゲーム情報を取得
    public static function find(string $gameId): Game;
    // 保存
    public static function save(Game $game): void;
}
