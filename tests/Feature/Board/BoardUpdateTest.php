<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Packages\Domain\Board\Board;
use Packages\Domain\Color\Color;
use Packages\Domain\Position\Position;
use Packages\Domain\Stone\Stone;
use Tests\TestCase;

class BoardTest extends TestCase
{

    const COLOR_WHITE = 1;
    const COLOR_BLACK = 2;
    /**
     * 盤面更新処理のテスト
     *
     * @return void
     */
    public function test_first_turn()
    {
        $emptyRow = collect()->pad(8, 0)->toArray();

        // 初期盤面
        $initBoard = [
            $emptyRow,
            $emptyRow,
            $emptyRow,
            collect($emptyRow)->put(3, self::COLOR_WHITE)->put(4, self::COLOR_BLACK)->toArray(),
            collect($emptyRow)->put(3, self::COLOR_BLACK)->put(4, self::COLOR_WHITE)->toArray(),
            $emptyRow,
            $emptyRow,
            $emptyRow,
        ];
        // [4,5]に白を置いたときの盤面
        $expected = $initBoard;
        $expected[3][4] = self::COLOR_WHITE;
        $expected[3][5] = self::COLOR_WHITE;

        $board = new Board($initBoard);
        $updated = $board->update(new Stone(new Color(self::COLOR_WHITE), new Position(3, 5)));

        $this->assertSame($expected, $updated->toArray());
    }
}
