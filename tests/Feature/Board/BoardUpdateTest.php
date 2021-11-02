<?php

namespace Tests\Feature\Board;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Packages\Domain\Board\Board;
use Packages\Domain\Color\Color;
use Tests\TestCase;

class BoardUpdateTest extends TestCase
{
    /**
     * テストケース
     * 初期盤面で正しい位置にコマを置く
     * 初期盤面で不正な位置にコマを置く
     *
     * 正常系
     * 一列内で複数個をひっくり返す
     * 複数列を同時にひっくり返す
     *
     * 異常系
     * 盤面外にコマを置く
     * 周りになにもない場所に置く
     *
     */

    const COLOR_WHITE = 1;
    const COLOR_BLACK = 2;
    /**
     * 盤面更新処理のテスト
     *
     * @return void
     */
    public function testFirstTurn()
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
        $updated = $board->update([4, 6], Color::white());
        $this->assertSame($expected, $updated->toArray());
    }
}
