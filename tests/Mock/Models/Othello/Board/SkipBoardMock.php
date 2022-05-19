<?php

namespace Tests\Mock\Models\Othello\Board;

use Packages\Models\Othello\Board\Board;
use Packages\Models\Othello\Board\Color\Color;

class SkipBoardMock
{
    public static function get(): Board
    {
        $w = Color::white()->toCode();
        // 白も黒も置ける場所がない盤面
        $board = [
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,$w,$w,0,0,0,],
            [0,0,0,$w,$w,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
        ];
        return Board::make($board);
    }
}
