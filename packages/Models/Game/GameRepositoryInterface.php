<?php

namespace Packages\Models\Game;

interface GameRepositoryInterface
{
    // ゲーム情報を取得
    public function find(): Game;
    // 保存
    public function save(Game $game): void;
}
