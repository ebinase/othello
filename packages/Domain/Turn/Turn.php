<?php

namespace Packages\Domain\Turn;

use Packages\Domain\Board\Board;
use Packages\Domain\Color\Color;

class Turn
{
    private TurnNumber  $turnNumber;
    private Color       $playerColor;
    private Board       $board;

    public function __construct(TurnNumber $turnNumber, Color $playerColor, Board $board)
    {
        $this->turnNumber   = $turnNumber;
        $this->playerColor  = $playerColor;
        $this->board        = $board;   
    }

    // ゲッター系
    public function getTurnNumber()
    {
        //
    }

    public function getPlayerColor()
    {
        //
    }

    public function getBoard()
    {
        //
    }

    // 複数クラス操作系
    public function next()
    {
        /*
        ・ ボードを更新
        ・ ターン+1
        ・ 色を反転
        ・ Turnオブジェクトに詰めて返却
        */
    }

    public function isPlayable()
    {
        
    }

    //　FIXME: TurnFlowServiceに移す？
    public function diff($board)
    {
        
    }

}
