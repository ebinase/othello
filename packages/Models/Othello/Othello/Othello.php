<?php

namespace Packages\Models\Othello\Othello;

use Illuminate\Support\Str;
use Packages\Exceptions\DomainException;
use Packages\Models\Othello\Action\Action;
use Packages\Models\Othello\Action\ActionType;

class Othello
{
    // スキップの連続を許容する回数
    const MAX_CONTINUOUS_SKIP_COUNT = 1;

    private function __construct(
        public readonly string $id,
        private Turn $turn,
        private int $skipCount
    ) {}

    public static function init(): Othello
    {
        return new self(
            id:         Str::uuid(),
            turn:       Turn::init(),
            skipCount:  0,
        );
    }

    public static function make(string $id, Turn $turn, int $skipCount): self
    {
        return new self(
            id:        $id,
            turn:      $turn,
            skipCount: $skipCount,
        );
    }

    /**
     * ゲームの状態更新
     * 連続スキップ数：スキップ時+1。スキップしない場合は0にリセット
     */
    public function apply(Action $action): void
    {
        // ゲームが終了している場合
        if ($this->isOver()) throw new DomainException();

        $this->turn = match ($action->actionType) {
            ActionType::SET_STONE => $this->turn->advance($action->data),
            ActionType::CONFIRM_SKIP => $this->turn->skip(),
        };
    }

    /**
     * ゲームが終了しているか判定する
     * 正常終了、スキップによる異常終了なのかは問わない
     *
     * @return bool
     */
    public function isOver(): bool
    {
        // ターンが進行不可(正常系)、もしくはスキップが連続してどちらも置く場所がなくなった(異常系)場合、終了
        $isInvalidSkipCount = $this->skipCount > self::MAX_CONTINUOUS_SKIP_COUNT;
        return !$this->turn->isAdvanceable() || $isInvalidSkipCount;
    }

    /**
     * @return Turn
     */
    public function getTurn(): Turn
    {
        return $this->turn;
    }

    /**
     * @return int
     */
    public function getSkipCount(): int
    {
        return $this->skipCount;
    }
}
