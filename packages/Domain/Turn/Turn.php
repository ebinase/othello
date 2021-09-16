<?php

namespace Packages\Domain\Turn;

use Packages\Domain\Board\Board;
use Packages\Domain\Color\Color;
use Packages\Domain\Stone\Stone;

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

    /**
     * 次のターンへ
     *
     * @param Stone $stone
     * @return void
     */
    public function next(Stone $stone)
    {
        // このターンに行動可能な色かチェック
        if (!$stone->colorEquals($this->playableColor)) {
            throw new \InvalidArgumentException();
        }

        return new Turn(
            $this->turnNumber + 1,
            $this->playableColor->opposite(),
            $this->board->flipStones($stone),
            $this->board->isPlacable($this->playableColor) ? 0 : $this->skipCount + 1
        );
    }

    //　FIXME: TurnFlowServiceに移す？
    public function diff($board)
    {
        
    }

}
