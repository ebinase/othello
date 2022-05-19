<?php

namespace Tests\Feature\Models\Othello\Turn;

use Packages\Models\Common\Matrix\Matrix;
use Packages\Models\Othello\Board\Board;
use Packages\Models\Othello\Board\Color\Color;
use Packages\Models\Othello\Board\Position\Position;
use Packages\Models\Othello\Othello\Turn;
use Tests\TestCase;

class TurnTest extends TestCase
{
    /** @test */
    public function ターン初期化()
    {
        // given:
        // when:
        $turn = Turn::init();

        // then:
        self::assertSame(1, $turn->turnNumber, 'ターン数は1から始まる');
        self::assertSame(true, Color::white()->equals($turn->playableColor), '白プレイヤーが先攻');
        self::assertSame(true, Board::init()->equals($turn->board), '初期盤面チェック');
    }

    // ---------------------------------------
    // コマを置く
    // ---------------------------------------

    /** @test */
    public function ターン更新()
    {
        // given:
        $turn = Turn::init(); // 1ターン目
        $move = Position::make([4, 6]); // 先行プレイヤーの1ターン目の指した場所
        // when:
        $next = $turn->advance($move); // ターンを進める
        // then:
        // 2ターン目の盤面
        $boardAtSecondTurn = Board::init()->update($move, Color::white());
        self::assertSame(2, $next->turnNumber, 'ターン数は2');
        self::assertSame(true, Color::Black()->equals($next->playableColor), '後攻のプレイヤーに交代');
        self::assertSame(true, $boardAtSecondTurn->equals($next->board), '盤面更新');
    }

    /** @test */
    public function おけない場所を指定された時は例外を出す()
    {
        // given:
        $turn = Turn::init(); // 1ターン目
        // when:
        $move = Position::make([1, 1]); // おけない場所
        // then:
        $this->expectException(\Exception::class);
        $turn->advance($move); // ターンを進める
    }

    // ---------------------------------------
    // スキップ系
    // ---------------------------------------
    /** @test */
    public function スキップ()
    {
        // given:
        $w = Color::white()->toCode();
        // 白も黒も置ける場所がない盤面

        $board = Board::make($board);

        // when:
        $turn1 = Turn::make(1, Color::black(), $board, 0);
        $turn2 = $turn1->advance();
        $turn3 = $turn2->advance();

        // then:
        // 2ターン目
        self::assertSame(1, $turn2->getSkipCount());
        self::assertSame(true, $turn2->mustSkip());
        self::assertSame(true, $turn2->isContinuable());
        // 3ターン目
        self::assertSame(2, $turn3->getSkipCount());
        self::assertSame(true, $turn2->mustSkip());
        self::assertSame(true, $turn2->isContinuable());
    }

    /** @test */
    public function 置ける場所があるのにスキップしようとした場合は例外を出す()
    {
        // given:
        // when:
        $turn = Turn::init(); // 1ターン目
        // then:
        $this->expectException(\Exception::class);
        // 置ける場所があるのに場所指定なしで更新した場合
        $turn->advance();
    }

    // ---------------------------------------
    // 終了条件系
    // ---------------------------------------
    /** @test */
    public function 盤面に空いているマスがなくなった時が最後のターン()
    {
        // given:
        $fullBoard = Board::make(Matrix::init(8, 8, Color::white()->toCode())->toArray());

        // when:
        $firstTurn = Turn::init();
        $lastTurn = Turn::make(20, Color::white(), $fullBoard, 0);
        // then:
        self::assertSame(false, !$firstTurn->isAdvanceable());
        self::assertSame(true, !$lastTurn->isAdvanceable());
    }


}
