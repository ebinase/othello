<?php

namespace Tests\Mock\Models\Othello\Board;

use Packages\Models\Common\Matrix\Matrix;
use Packages\Models\Othello\Board\Board;
use Packages\Models\Othello\Board\Color\Color;

class OneLastActionBoard
{
    public static function get8行8列に白を置くとすべて埋まる盤面(): Board
    {
        $matrix = Matrix::init(
            8,
            8,
            Color::white()->toCode()
        );
        $matrix->setData(Color::black()->toCode(), 8, 7);
        $matrix->setData(Board::BOARD_EMPTY, 8, 8);
        return Board::make(
            $matrix->toArray()
        );
    }
}
