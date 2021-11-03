<?php

namespace Packages\Domain\Turn;

use Packages\Domain\Board\Board;
use Packages\Domain\Color\Color;

class Turn
{
    private int    $turnNumber;
    private Color  $playableColor;
    private Board  $board;
    private int    $skipCount;

    public function __construct(int $turnNumber, Color $playableColor, Board $board, int $skipCount)
    {
        if ($turnNumber < 0) {
            throw new \InvalidArgumentException();
        }

        $this->turnNumber    = $turnNumber;
        $this->playableColor = $playableColor;
        $this->board         = $board;
        $this->skipCount     = $skipCount;
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

    /**
     * 次のターンへ
     */
    public function next(array $position)
    {
//        $stone = app()->make('Stone', [$this->playableColor, $position]);
//
//        return new Turn(
//            $this->turnNumber + 1,
//            $this->playableColor->opposite(),
//            $this->board->update($stone),
//            $this->board->isPlayable($this->playableColor) ? 0 : $this->skipCount + 1
//        );
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
