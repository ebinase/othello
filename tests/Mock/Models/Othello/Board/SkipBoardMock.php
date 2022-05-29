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

    public static function 白を4行5列に置くと両色ともスキップせざるを得なくなる盤面(): Board
    {
        $w = Color::white()->toCode();
        $b = Color::black()->toCode();
        $board = [
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,$w, 0,0,0,0,],
            [0,0,0,$w,$b,0,0,0,],
            [0,0,0, 0,$w,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
        ];
        return Board::make($board);
    }
}
