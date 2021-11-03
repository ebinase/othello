<?php

namespace Tests\Feature\Board;

use Packages\Domain\Board\Board;
use Packages\Domain\Color\Color;
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
            [0,0,0,Color::COLOR_WHITE,Color::COLOR_BLACK,0,0,0,],
            [0,0,0,Color::COLOR_BLACK,Color::COLOR_WHITE,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
        ];

        self::assertSame($expected, $newBoard->toArray());
    }
}
