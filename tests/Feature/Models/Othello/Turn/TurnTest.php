<?php

namespace Tests\Feature\Models\Othello\Turn;

use Packages\Exceptions\DomainException;
use Packages\Models\Core\Board\Board;
use Packages\Models\Core\Board\Color\Color;
use Packages\Models\Core\Board\Position\Position;
use Packages\Models\Core\Turn\Turn;
use Tests\Mock\Models\Othello\Board\FulfilledBoard;
use Tests\Mock\Models\Othello\Board\SkipBoardMock;
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
        $this->expectException(DomainException::class);
        $turn->advance($move); // ターンを進める
    }

    // ---------------------------------------
    // スキップ系
    // ---------------------------------------
    /** @test */
    public function スキップをした場合ターン数増加とプレイヤー交代はするが盤面は変わらない()
    {
        // given:
        // 白も黒も置ける場所がない盤面
        $board = SkipBoardMock::get();
        $turn1 = Turn::make(1, Color::white(), $board);

        // when:
        $turn2 = $turn1->skip(); // 白のスキップ
        dump($turn2->playableColor);
        $turn3 = $turn2->skip(); // 黒のスキップ

        // then:
        // 2ターン目
        self::assertSame(2, $turn2->turnNumber);
        self::assertTrue(Color::black()->equals($turn2->playableColor), '黒に交代');
        self::assertTrue($board->equals($turn2->board), '初回の盤面から変更なし');
        // 3ターン目
        self::assertSame(3, $turn3->turnNumber);
        self::assertTrue(Color::white()->equals($turn3->playableColor), '白に交代');
        self::assertTrue($board->equals($turn3->board), '初回の盤面から変更なし');
    }

    /** @test */
    public function 置ける場所があるのにスキップしようとした場合は例外を出す()
    {
        // when:
        $turn = Turn::init(); // 1ターン目
        // then:
        $this->expectException(DomainException::class);
        // 置ける場所があるのに場所指定なしで更新した場合
        $turn->skip();
    }

    // ---------------------------------------
    // 終了条件系
    // ---------------------------------------
    /** @test */
    public function 盤面に空いているマスがなくなった時が最後のターン()
    {
        // when:
        $firstTurn = Turn::init();
        $lastTurn = Turn::make(20, Color::white(), FulfilledBoard::get());
        // then:
        self::assertFalse($firstTurn->isLast());
        self::assertTrue($lastTurn->isLast());
    }
}
