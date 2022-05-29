<?php

namespace Packages\Models\GameOrganizer;

interface GameRepositoryInterface
{
    // ゲーム情報を取得
    public function findById(string $gameId): ?Game;
    // 保存
    public function save(Game $game): void;
}
