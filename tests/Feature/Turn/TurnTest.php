<?php

namespace Tests\Feature\Turn;

use Packages\Domain\Board\Board;
use Packages\Domain\Color\Color;
use Packages\Domain\Turn\Turn;
use Tests\TestCase;

class TurnTest extends TestCase
{
    public function test初期ターン作成()
    {
        // given:

        // when:
        $turn = Turn::init();

        // then:
        self::assertSame(1, $turn->getTurnNumber(), 'ターン数は1から始まる');
        self::assertSame(true, Color::white()->equals($turn->getPlayableColor()->toCode()), '白プレイヤーが先攻');
        self::assertSame(true, Board::init()->equals($turn->getBoard()), '初期盤面チェック');
        self::assertSame(0, $turn->getSkipCount(), 'スキップカウントは0');
    }

//    public function testテストの内容()
//    {
//        // given:
//
//        // when:
//
//        // then:
//
//    }
}
