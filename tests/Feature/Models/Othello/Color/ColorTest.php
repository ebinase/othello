<?php

namespace Tests\Feature\Models\Othello\Color;

use Packages\Models\Othello\Board\Color\Color;
use Tests\TestCase;

class ColorTest extends TestCase
{

    public function test変換系()
    {
        $whiteCode = Color::COLOR_CODE_WHITE;
        $blackCode = Color::COLOR_CODE_BLACK;
        $white = Color::white();
        $black = Color::black();

        $this->assertSame(true, $white->opposite()->equals($black));
        $this->assertSame(true, $black->opposite()->equals($white));
    }


    public function test比較系()
    {
        // given:
        $whiteCode = Color::COLOR_CODE_WHITE;
        $blackCode = Color::COLOR_CODE_BLACK;
        $white = Color::white();
        $black = Color::black();

        // then:
        // カラーコードか
        $this->assertSame(true, $white::isColorCode($whiteCode));
        $this->assertSame(false, $white::isColorCode('hoge'));
        // コードが等しいか
        $this->assertSame(true, $white->codeEquals($whiteCode));
        $this->assertSame(false, $white->codeEquals($blackCode));
        $this->assertSame(false, $white::isColorCode('hoge'));
        // 反対のカラーコードか
        $this->assertSame(true, $white->isOppositeCode($blackCode));
        $this->assertSame(false, $white->isOppositeCode($whiteCode));
        $this->assertSame(false, $white::isColorCode('hoge'));
        // 同じ色のオブジェクトか
        $this->assertSame(true, $white->equals($white));
        $this->assertSame(false, $white->equals($black));
        // 反対の色のオブジェクトか
        $this->assertSame(true, $white->isOpposite($black));
        $this->assertSame(false, $white->isOpposite($white));

    }
}
