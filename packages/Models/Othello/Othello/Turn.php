<?php

namespace Packages\Models\Othello\Othello;

use Packages\Models\Othello\Board\Board;
use Packages\Models\Othello\Board\Color\Color;
use Packages\Models\Othello\Board\Position\Position;

class Turn
{
    private function __construct(
        public readonly int    $turnNumber,
        public readonly Color  $playableColor,
        public readonly Board  $board,
    )
    {
        if ($turnNumber <= 0) {
            throw new \InvalidArgumentException();
        }
    }

    public static function init(): Turn
    {
        return new Turn(
            turnNumber:    1,
            playableColor: Color::white(),
            board:         Board::init(),
        );
    }

    public static function make(int $turnNumber, Color $playableColor, Board $board): Turn
    {
        return new Turn(
            turnNumber:    $turnNumber,
            playableColor: $playableColor,
            board:         $board,
        );
    }

    /**
     * 次のターンへ
     * ターン数：+1
     * 色：反対の色へ
     * 盤面：コマを置いて更新。スキップの場合は現在のものをそのまま設定
     */
    public function next(?Position $position = null): Turn
    {
        // ゲームが終了している場合
        if ($this->finishedLastTurn()) throw new \RuntimeException();
        // ゲームが続行不能な場合
        if (!$this->isContinuable()) throw new \RuntimeException();

        if ($this->mustSkip()) {

        }

        // コマを置くことができる場合、盤面を更新してスキップカウントをリセット
        // 必須チェック
        if (!isset($position)) throw new \Exception('コマを置くことができるマスがある場合、スキップはできません。');
        // 指定された場所にコマを置くことができるか確認
        if (!$this->board->isValid($position, $this->playableColor)) throw new \Exception('指定された場所に置くことができません。');

        return new Turn(
            $this->turnNumber + 1,
            $this->playableColor->opposite(),
            $this->board->update($position, $this->playableColor),
        );
    }

    public function skip()
    {
        return new Turn(
            $this->turnNumber + 1,
            $this->playableColor->opposite(),
            $this->board,
        );
    }

    /**
     * 最終ターンが終了しているか(=ゲームが正常終了しているか)判定
     * @return bool
     */
    public function finishedLastTurn(): bool
    {
        return $this->board->isFulfilled();
    }

    public function mustSkip(): bool
    {
        return !$this->board->hasPlayablePosition($this->playableColor);
    }


}
