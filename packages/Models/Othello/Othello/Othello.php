<?php

namespace Packages\Models\Othello\Othello;

use Illuminate\Support\Str;
use Packages\Models\Othello\Action\Action;

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
    public function next(Action $action): void
    {
        // ゲームが終了している場合
        if ($this->finishedLastTurn()) throw new \RuntimeException();
        // ゲームが続行不能な場合
        if (!$this->isContinuable()) throw new \RuntimeException();

        // スキップするときは盤面はそのままで、スキップカウントを加算する
        if ($this->turn->mustSkip()) {
            $this->skipCount + 1;
        }

        // コマを置くことができる場合、盤面を更新してスキップカウントをリセット
        // 必須チェック
        if (!isset($position)) throw new \Exception('コマを置くことができるマスがある場合、スキップはできません。');
        // 指定された場所にコマを置くことができるか確認
        if (!$this->board->isValid($position, $this->playableColor)) throw new \Exception('指定された場所に置くことができません。');
    }

    public function isPlayable()
    {
        $this->turn->isAdvanceable();
    }

    /**
     * ゲームが継続可能か判定
     * 決着(最後のターン到達)以外のゲームの途中終了条件の判定をする
     * @return bool
     */
    public function isContinuable(): bool
    {
        $isInvalidSkipCount = $this->skipCount > self::MAX_CONTINUOUS_SKIP_COUNT;
        return !$isInvalidSkipCount;
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
