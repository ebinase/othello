<?php

namespace Packages\Models\Othello\Othello;

use Packages\Exceptions\DomainException;
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
            throw new DomainException();
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
     * 盤面：コマを置いて更新。
     */
    public function advance(Position $position): Turn
    {
        // これ以上進めない場合
        if ($this->isLast()) throw new DomainException();
        // スキップするしかない場合はコマを置けない
        if ($this->mustSkip()) throw new DomainException('このターンはスキップ以外できません。');

        return new Turn(
            $this->turnNumber + 1,
            $this->playableColor->opposite(),
            $this->board->update($position, $this->playableColor),
        );
    }

    /**
     * 次のターンへ
     * ターン数：+1
     * 色：反対の色へ
     * 盤面：スキップの場合は現在のものをそのまま設定
     */
    public function skip(): Turn
    {
        // これ以上進めない場合
        if ($this->isLast()) throw new DomainException();
        // コマを置くことができる場合はスキップできない
        if (!$this->mustSkip()) throw new DomainException('コマを置くことができるマスがある場合、スキップはできません。');

        return new Turn(
            $this->turnNumber + 1,
            $this->playableColor->opposite(),
            $this->board,
        );
    }

    /**
     * 最終ターンが終了しているか判定
     * @return bool
     */
    public function isLast(): bool
    {
        // 盤面がいっぱいになっていなかったら最終ターンに到達していない = 進行可能
        return $this->board->isFulfilled();
    }

    public function mustSkip(): bool
    {
        return !$this->board->hasPlayablePosition($this->playableColor);
    }
}
