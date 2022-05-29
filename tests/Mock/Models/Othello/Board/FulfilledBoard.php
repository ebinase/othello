<?php

namespace Tests\Mock\Models\Othello\Board;

use Packages\Models\Common\Matrix\Matrix;
use Packages\Models\Othello\Board\Board;
use Packages\Models\Othello\Board\Color\Color;

class FulfilledBoard
{
    public static function get(): Board
    {
        return Board::make(
            Matrix::init(
                8,
                8,
                Color::white()->toCode()
            )->toArray()
        );
    }
}
