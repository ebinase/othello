<?php

namespace Tests\Feature\Models\Othello\Othello;

use Packages\Models\Common\Matrix\Matrix;
use Packages\Models\Othello\Action\Action;
use Packages\Models\Othello\Action\ActionType;
use Packages\Models\Othello\Board\Board;
use Packages\Models\Othello\Board\Color\Color;
use Packages\Models\Othello\Board\Position\Position;
use Packages\Models\Othello\Othello\Othello;
use Packages\Models\Othello\Othello\Turn;
use Tests\Mock\Models\Othello\Board\SkipBoardMock;
use Tests\TestCase;

class OthelloTest extends TestCase
{
    /** @test */
    public function オセロ初期化()
    {
        // when:
        $othello = Othello::init();

        // then:
        self::assertTrue(\Str::isUuid($othello->id));
        self::assertSame(0, $othello->getSkipCount(), 'スキップカウントは0');
        // 下記の値はそのまま設定される
        self::assertTrue(Turn::init() == $othello->getTurn());
    }

    /** @test */
    public function 通常更新()
    {
        // given:
        $othello = Othello::init(); // 1ターン目
        $action = Action::make(ActionType::SET_STONE, Position::make([4, 6])); // 先行プレイヤーの1ターン目の指した場所
        // when:
        $othello->attach($action); // ターンを進める
        // then:
        // 2ターン目の盤面
        $boardAtSecondTurn = Board::init()->update($move, Color::white());
        self::assertSame(2, $next->getTurnNumber(), 'ターン数は2');
        self::assertSame(true, Color::Black()->equals($next->getPlayableColor()), '後攻のプレイヤーに交代');
        self::assertSame(true, $boardAtSecondTurn->equals($next->getBoard()), '盤面更新');
        self::assertSame(0, $next->getSkipCount(), 'スキップカウントは0');
    }

    /** @test */
    public function 不正なアクションを指定された時は例外を出す()
    {
        // given:
        $turn = Turn::init(); // 1ターン目
        // when:

        $move = Position::make(ActionType::SET_STONE); // おけない場所
        // then:
        $this->expectException(\Exception::class);
        $turn->advance($move); // ターンを進める
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
        self::assertSame(true, $firstTurn->isAdvanceable());
        self::assertSame(false, $lastTurn->isAdvanceable());
    }

    /** @test */
    public function スキップが2ターン続いたらそれ以降は一切更新不可()
    {
        // given:
        $position = Position::make([4, 6]);

        // when:
        $turnSkip0 = Turn::make(20, Color::white(), Board::init(), 0);
        $turnSkip1 = Turn::make(20, Color::white(), Board::init(), 1);
        $turnSkip2 = Turn::make(20, Color::white(), Board::init(), 2);

        // then:
        // isContinuable()テスト
        self::assertSame(true,  $turnSkip0->isContinuable());
        self::assertSame(true,  $turnSkip1->isContinuable());
        self::assertSame(false, $turnSkip2->isContinuable());
        // skipカウントとupdateのテスト
        self::assertSame(true,  !empty($turnSkip0->advance($position))); // next()が問題なく実行できればOK
        self::assertSame(true,  !empty($turnSkip1->advance($position))); // next()が問題なく実行できればOK
        // スキップが2回続いたターンを更新しようとすると例外
        self::expectException(\Exception::class);
        $turnSkip2->advance($position);
    }

    // ---------------------------------------
    // スキップ系
    // ---------------------------------------
    /** @test */
    public function 盤面における場所がなかったらスキップカウントがアップ()
    {
        // given:
        // 白も黒も置ける場所がない盤面
        $board = SkipBoardMock::get();

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
    public function スキップされなかった時、カウントは0に戻る()
    {
        // given:
        $w = Color::white()->toCode();
        $b = Color::black()->toCode();
        // 黒がスキップする盤面
        $board = [
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,$b,$w,$b,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
            [0,0,0,0,0,0,0,0,],
        ];
        $board = Board::make($board);

        // when:
        // 黒のターンとして生成
        $turn1 = Turn::make(1, Color::black(), $board, 0);
        // 黒が行動(スキップ)
        $turn2 = $turn1->advance();
        // 白が行動
        $turn3 = $turn2->advance(Position::make([4, 2]));

        // then:
        // 2ターン目(黒の行動後の白のターン)
        self::assertSame(1, $turn2->getSkipCount(), 'スキップしたのでカウントアップ');
        // 3ターン目(白の行動後の黒のターン)
        self::assertSame(0, $turn3->getSkipCount(), '色に関わらず行動できたときはリセット');
    }


}
