<?php

namespace Packages\Domain\Turn;

interface TurnRepositoryInterface
{
    // 現在のターン情報を取得
    public function getCurrent(): Turn;
    // 保存
    public function store(): bool;
}
