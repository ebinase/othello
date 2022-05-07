<?php

namespace Packages\Repositories\Game;

use Packages\Models\GameOrganizer\Game;

interface GameRepositoryInterface
{
    // ゲーム情報を取得
    public function findById(string $gameId): ?Game;
    // 保存
    public function save(Game $game): void;
}
