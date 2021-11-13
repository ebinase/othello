<?php

namespace Packages\Models\Turn;

use Packages\Models\Board\Board;
use Packages\Models\Board\Color\Color;
use Packages\Models\Board\Position\Position;

class Turn
{
    // スキップの連続を許容する回数
    const MAX_CONTINUOUS_SKIP_COUNT = 1;

    private function __construct(
        private int $turnNumber,
        private Color $playableColor,
        private Board $board,
        private int $skipCount
    )
    {
        if ($turnNumber < 0) {
            throw new \InvalidArgumentException();
        }
    }

    public static function init(): Turn
    {
        return new Turn(
            turnNumber:    1,
            playableColor: Color::white(),
            board:         Board::init(),
            skipCount:     0,
        );
    }

    public static function make(int $turnNumber, Color $playableColor, Board $board, int $skipCount): Turn
    {
        return new Turn(
            turnNumber:    $turnNumber,
            playableColor: $playableColor,
            board:         $board,
            skipCount:     $skipCount,
        );
    }

    /**
     * 次のターンへ
     * ターン数：+1
     * 色：反対の色へ
     * 盤面：コマを置いて更新。スキップの場合は現在のものをそのまま設定
     * 連続スキップ数：スキップ時+1。スキップしない場合は0にリセット
     */
    public function next(?Position $position = null): Turn
    {
        // ゲームが終了している場合
        if ($this->isLastTurn()) throw new \RuntimeException();
        // ゲームが続行不能な場合
        if (!$this->isContinuable()) throw new \RuntimeException();

        // スキップするときは盤面はそのままで、スキップカウントを加算する
        if ($this->mustSkip()) {
            return new Turn(
                $this->turnNumber + 1,
                $this->playableColor->opposite(),
                $this->board,
                $this->skipCount + 1
            );
        }

        // コマを置くことができる場合、盤面を更新してスキップカウントをリセット
        // 必須チェック
        if (!isset($position)) throw new \Exception('コマを置くことができるマスがある場合、スキップはできません。');
        // 指定された場所にコマを置くことができるか確認
        if (!$this->board->isValid($position, $this->playableColor)) throw new \Exception();

        return new Turn(
            $this->turnNumber + 1,
            $this->playableColor->opposite(),
            $this->board->update($position, $this->playableColor),
            0
        );
    }

    /**
     * 最後のターンかどうかを判定
     * @return bool
     */
    public function isLastTurn(): bool
    {
        // TODO: メソッド名を変更(厳密には「最後のターンの次」なので)
        return $this->board->getRest() === 0;
    }

    /**
     * ゲームが継続可能か判定
     * 決着(最後のターン到達)以外のゲームの途中終了条件の判定をする
     * @return bool
     */
    public function isContinuable(): bool
    {
        if ($this->skipCount > self::MAX_CONTINUOUS_SKIP_COUNT) return false;
        return true;
    }

    public function mustSkip(): bool
    {
        return !$this->board->hasPlayablePosition($this->playableColor);
    }

    // HACK: TurnFlowServiceに移す？
    public function diff($board)
    {

    }

    /**
     * @return int
     */
    public function getTurnNumber(): int
    {
        return $this->turnNumber;
    }

    /**
     * @return Color
     */
    public function getPlayableColor(): Color
    {
        return $this->playableColor;
    }

    /**
     * @return Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * @return int
     */
    public function getSkipCount(): int
    {
        return $this->skipCount;
    }
}
