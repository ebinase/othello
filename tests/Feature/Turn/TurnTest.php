<?php

namespace Tests\Feature\Turn;

use Packages\Models\Board\Board;
use Packages\Models\Board\Color\Color;
use Packages\Models\Board\Position\Position;
use Packages\Models\Turn\Turn;
use Tests\TestCase;

class TurnTest extends TestCase
{
    public function testターン初期化()
    {
        // given:

        // when:
        $turn = Turn::init();


        // then:
        self::assertSame(1, $turn->getTurnNumber(), 'ターン数は1から始まる');
        self::assertSame(true, Color::white()->equals($turn->getPlayableColor()), '白プレイヤーが先攻');
        self::assertSame(true, Board::init()->equals($turn->getBoard()), '初期盤面チェック');
        self::assertSame(0, $turn->getSkipCount(), 'スキップカウントは0');
    }

    public function testターン更新()
    {
        // given:
        $turn = Turn::init(); // 1ターン目
        $move = Position::make([4, 5]); // 先行プレイヤーの1ターン目の指した場所
        // when:
        $turn->next($move); // ターンを進める
        // then:
        // 2ターン目の盤面
        $boardAtSecondTurn = Board::init()->update($move, Color::white());

        self::assertSame(2, $turn->getTurnNumber(), 'ターン数は2');
        self::assertSame(true, Color::Black()->equals($turn->getPlayableColor()), '後攻のプレイヤーに交代');
        self::assertSame(true, $boardAtSecondTurn->equals($turn->getBoard()), '盤面更新');
        self::assertSame(0, $turn->getSkipCount(), 'スキップカウントは0');
    }

    // ---------------------------------------
    // 終了条件系
    // ---------------------------------------
    public function test盤面に空いているマスがなくなった時が最後のターン()
    {
        // given:

        // when:

        // then:

    }

    public function testスキップが2ターン続いたらそれ移行は一切更新不可()
    {
        // given:

        // when:

        // then:

    }

    // ---------------------------------------
    // ターンのルール
    // ---------------------------------------

    public function test各ターンでは特定の色しか行動できない()
    {
        // given:

        // when:

        // then:

    }

    public function test各ターンで行動できるのは1度だけ()
    {
        // given:

        // when:

        // then:

    }

    public function test盤面における場所がなかったらスキップカウントがアップ()
    {
        // given:

        // when:
        $turn = new Turn(10, Color::black());
        // then:

    }

    public function testスキップされなかった時、カウントは0に戻る()
    {
        // given:

        // when:

        // then:

    }
}
