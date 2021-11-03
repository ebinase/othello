<?php

namespace Tests\Feature\Board;

use Packages\Models\Board\Board;
use Packages\Models\Board\Color;
use Tests\TestCase;

class BoardInitializingTest extends TestCase
{
    public function test初期盤面作成()
    {
        // given:

        // when:
        $newBoard = Board::init();
        // then:
        $expected = [
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,Color::COLOR_CODE_WHITE,Color::COLOR_CODE_BLACK,0,0,0,],
            [0,0,0,Color::COLOR_CODE_BLACK,Color::COLOR_CODE_WHITE,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
        ];

        self::assertSame($expected, $newBoard->toArray());
    }
}
