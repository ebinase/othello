<?php

namespace Packages\Models\Core;

use Packages\Models\Core\Othello\Othello;

interface OthelloRepositoryInterface
{
    // 情報を取得
    public function findById(string $gameId): Othello;
    // 保存
    public function save(Game $game): void;
}
