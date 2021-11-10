<?php

namespace Tests\Feature\Board;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Packages\Models\Board\Board;
use Packages\Models\Board\Color\Color;
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

    /**
     * 盤面更新処理のテスト
     *
     * @return void
     */
    public function testFirstTurn()
    {
        // given:
        $w = Color::white()->toCode();
        $b = Color::black()->toCode();
        $initialBoard = Board::init();
        // when:
        $updated = $initialBoard->update([4, 6], Color::white());
        // then:
        // [4,5]に白を置いたときの盤面
        $expected = [
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,$w,$w,$w,0,0,],
            [0,0,0,$b,$w,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
        ];

        $this->assertSame($expected, $updated->toArray());
    }
}
