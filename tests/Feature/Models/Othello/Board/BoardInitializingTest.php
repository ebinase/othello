<?php

namespace Tests\Feature\Models\Othello\Board;

use Packages\Models\Othello\Board\Board;
use Packages\Models\Othello\Board\Color\Color;
use Tests\TestCase;

class BoardInitializingTest extends TestCase
{
    public function test初期盤面作成()
    {
        // given:
        $w = Color::white()->toCode();
        $b = Color::black()->toCode();
        // when:
        $newBoard = Board::init();
        // then:
        $expected = [
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,$w,$b,0,0,0,],
            [0,0,0,$b,$w,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
        ];

        self::assertSame($expected, $newBoard->toArray());
    }
}